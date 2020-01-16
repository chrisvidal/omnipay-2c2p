<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    const API_VERSION = null;

    public function getVersion()
    {
        return $this->getParameter('version') ?: static::API_VERSION;
    }

    public function setVersion($version)
    {
        return $this->setParameter('version', $version);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($merchantId)
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    public function getRefundNotifyUrl()
    {
        return $this->getParameter('refundNotifyUrl');
    }

    public function setRefundNotifyUrl($refundNotifyUrl)
    {
        return $this->setParameter('refundNotifyUrl', $refundNotifyUrl);
    }

    public function getTimeZone()
    {
        return $this->getParameter('timezone');
    }

    public function setTimeZone(\DateTimeZone $timeZone)
    {
        return $this->setParameter('timezone', $timeZone);
    }

    public function getRequestUrl()
    {
        return $this->getTestMode() ? $this->endPointTest : $this->endPointProduction;
    }

    public function getRequestMethod()
    {
        return 'POST';
    }

    protected function implodeArray($data)
    {
        if (is_string($data)) {
            return $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->implodeArray($val);
            }
        }

        return implode('', array_values($data));
    }

    protected function emptyIfNotFound($haystack, $needle)
    {
        if (!isset($haystack[$needle])) {
            return '';
        }

        if (is_array($haystack[$needle])) {
            return $this->implodeArray($haystack[$needle]);
        }

        return $haystack[$needle];
    }

    protected function sortListField($haystack, $needle)
    {
        if (isset($haystack[$needle])) {
            if (is_array($list = $haystack[$needle])) {
                $array = [];
                switch ($needle) {
                    case 'subMerchantList':
                        $sortKey = ['subMID', 'subAmount'];
                        break;
                    case 'refundList':
                        $list = array_values($list['refund']);
                        $sortKey = [
                            'referenceNo', 'status', 'amount', 'dateTime', 'userDefined1', 'userDefined2',
                            'userDefined3', 'userDefined4', 'userDefined5'
                        ];
                        break;
                    default:
                        return $haystack;
                }

                foreach ($list as $item) {
                    $tmp = [];
                    foreach ($sortKey as $key) {
                        isset($item[$key]) && $tmp[$key] = $item[$key];
                    }
                    !empty($tmp) && array_push($array, $tmp);
                    unset($tmp);
                }

                if (!empty($array)) {
                    $haystack[$needle] = $array;
                }
            }
        }

        return $haystack;
    }

    protected function filterData(array $data)
    {
        foreach ($data as $k => $v) {
            if (is_null($v)) {
                unset($data[$k]);
            }
        }

        return $data;
    }

    protected function mergeData(array $data, array $_data)
    {
        return array_merge($data, $_data);
    }
}
