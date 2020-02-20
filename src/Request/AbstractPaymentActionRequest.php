<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Exception;
use Omnipay\CreditCardPaymentProcessor\Common\PKCS7;
use Omnipay\CreditCardPaymentProcessor\Common\XMLHelper;

abstract class AbstractPaymentActionRequest extends AbstractRequest
{
    const API_VERSION = '3.4';

    protected $endPointTest = 'https://demo2.2c2p.com/2C2PFrontend/PaymentActionV2/PaymentAction.aspx';
    protected $endPointProduction = 'https://t.2c2p.com/PaymentActionV2/PaymentAction.aspx';

    public function getRequestPublicKey()
    {
        return $this->getParameter('requestPublicKey');
    }

    public function setRequestPublicKey($publicKey)
    {
        return $this->setParameter('requestPublicKey', $publicKey);
    }

    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    public function setPublicKey($publicKey)
    {
        return $this->setParameter('publicKey', $publicKey);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($privateKey)
    {
        return $this->setParameter('privateKey', $privateKey);
    }

    public function getPKCS7Password()
    {
        return $this->getParameter('pkcs7Password');
    }

    public function setPKCS7Password($password)
    {
        return $this->setParameter('pkcs7Password', $password);
    }

    public function getTempDir()
    {
        return $this->getParameter('tempDir');
    }

    public function setTempDir($dir)
    {
        return $this->setParameter('tempDir', $dir);
    }

    public function getRequestTimestamp()
    {
        return $this->getParameter('timeStamp');
    }

    public function setRequestTimestamp($timestamp)
    {
        return $this->setParameter('timeStamp', $timestamp);
    }

    public function getUserDefined(int $rank = 1)
    {
        return $rank >= 0 && $rank <= 5 ? $this->getParameter('userDefined' . $rank) : null;
    }

    public function setUserDefined($value, int $rank = 1)
    {
        return $rank >= 0 && $rank <= 5 ? $this->setParameter('userDefined' . $rank, $value) : null;
    }

    public function getProcessType()
    {
        return $this->processType ?? '';
    }

    public function getRequestTimestampFormatted()
    {
        $timestamp = $this->getRequestTimestamp();
        if (!$timestamp) {
            return null;
        }

        if (!($timestamp instanceof \DateTime)) {
            if (!is_numeric($timestamp)) {
                $timestamp = strtotime($timestamp);
            }
            $_timestamp = new \DateTime();
            $_timestamp->setTimestamp($timestamp);
            $timestamp = $_timestamp;
        }

        if ($timezone = $this->getTimeZone()) {
            $timestamp->setTimezone($timezone);
        }

        return $timestamp->format('dmyHis');
    }

    public function getRequestBody($data = null)
    {
        if (!$data) {
            $data = $this->getData();
        }

        $xml = XMLHelper::generateXmlFromArray($data, 'PaymentProcessRequest', '')->asXML();
        $xml = str_replace('<?xml version="1.0"?>', '', $xml);
        $xml = trim($xml, "\n");
        if (!$xml) {
            throw new Exception("Error format when transforming the xml object to string");
        }

        return $xml;
    }

    public function decode($data) : array
    {
        $payload = XMLHelper::loadXmlStringAsArray(
            PKCS7::decrypt(
                $data,
                $this->getPublicKey(),
                $this->getPrivateKey(),
                $this->getPKCS7Password(),
                $this->getTempDir()
            )
        );

        if (!is_array($payload)) {
            throw new Exception("Decode data error, payload: " . $payload);
        }

        foreach ($payload as $k => $v) {
            if (empty($v)) {
                $payload[$k] = '';
            }
        }

        return $payload;
    }

    public function getData()
    {
        $this->validate(
            'requestPublicKey',
            'publicKey',
            'privateKey',
            'pkcs7Password',
            'merchantId',
            'transactionId'
        );

        $data = [
            'version' => $this->getVersion(),
            'timeStamp' => $this->getRequestTimestampFormatted(),
            'merchantID' => $this->getMerchantId(),
            'processType' => $this->getProcessType(),
            'invoiceNo' => $this->getTransactionId()
        ];

        for ($i = 1; $i <= 5; $i++) {
            $data['userDefined' . $i] = $this->getUserDefined($i);
        }

        return $data;
    }

    public function sendData($data)
    {
        $url = $this->getRequestUrl();
        $method = $this->getRequestMethod();
        $body = $this->getRequestBody($data);
        $payload = 'paymentRequest=' . PKCS7::encrypt($body, $this->getRequestPublicKey(), $this->getTempDir());

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];

        $response = $this->httpClient->request($method, $url, $headers, $payload);
        $responseCode = $response->getStatusCode();
        if ($responseCode == 200) {
            return $this->decode($response->getBody()->getContents());
        } else {
            throw new Exception($response->getReasonPhrase(), $responseCode);
        }
    }

    protected function hashValue($data)
    {
        $strToHash =
            $this->emptyIfNotFound($data, 'version') .
            $this->emptyIfNotFound($data, 'merchantID') .
            $this->emptyIfNotFound($data, 'processType') .
            $this->emptyIfNotFound($data, 'invoiceNo') .
            $this->emptyIfNotFound($data, 'actionAmount') .
            $this->emptyIfNotFound($data, 'bankCode') .
            $this->emptyIfNotFound($data, 'accountName') .
            $this->emptyIfNotFound($data, 'accountNumber') .
            $this->emptyIfNotFound(
                $this->sortListField($data, 'subMerchantList'), 'subMerchantList'
            ) .
            $this->emptyIfNotFound($data, 'notifyURL') .
            $this->emptyIfNotFound($data, 'userDefined1') .
            $this->emptyIfNotFound($data, 'userDefined2') .
            $this->emptyIfNotFound($data, 'userDefined3') .
            $this->emptyIfNotFound($data, 'userDefined4') .
            $this->emptyIfNotFound($data, 'userDefined5')
        ;

        return hash_hmac('sha1', $strToHash, $this->getSecretKey(), false);
    }
}

