<?php

namespace Omnipay\CreditCardPaymentProcessor\Response;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\CreditCardPaymentProcessor\Common\PaymentActionReference;
use Omnipay\CreditCardPaymentProcessor\Request\AbstractPaymentActionRequest;

abstract class AbstractPaymentActionResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        $this->data['hashValue'] = strtolower($this->data['hashValue'] ?? '');
        $this->data['completedHashValue'] = strtolower($this->hashValue($this->data));

        if (!$this->validateHashValue($this->data)) {
            $this->data['respCode'] = PaymentActionReference::RESULT_INVALID_HASH;
        }
    }

    public function isSuccessful()
    {
        return $this->data['respCode'] == PaymentActionReference::RESULT_SUCCESS;
    }

    public function getCode()
    {
        return $this->data['respCode'];
    }

    public function getMessage()
    {
        return $this->data['respDesc'];
    }

    public function getTransactionReference()
    {
        return $this->data['referenceNo'];
    }

    public function getTransactionId()
    {
        return $this->data['invoiceNo'];
    }

    public function getVersion()
    {
        return $this->data['version'];
    }

    public function getTimestamp()
    {
        if (!isset($this->data['timeStamp']))
            return 0;

        $datetime = \DateTime::createFromFormat('dmyHis', $this->data['timeStamp'], $this->request->getTimeZone());
        return $datetime->getTimestamp();
    }

    public function getProcessType()
    {
        return $this->data['processType'];
    }

    public function getAmount() : float
    {
        if (!isset($this->data['amount']))
            return 0;

        return floatval($this->data['amount']);
    }

    public function getStatus()
    {
        return $this->data['status'];
    }

    public function getApprovalCode()
    {
        return $this->data['approvalCode'];
    }

    public function getTransactionTimestamp()
    {
        if (!isset($this->data['transactionDateTime']))
            return 0;

        $datetime = \DateTime::createFromFormat('YmdHis', $this->data['transactionDateTime'], $this->request->getTimeZone());
        return $datetime->getTimestamp();
    }

    public function getMaskedPan()
    {
        return $this->data['maskedPan'];
    }

    public function getECI()
    {
        return $this->data['eci'] ?? null;
    }

    public function getPaymentScheme()
    {
        return $this->data['paymentScheme'];
    }

    public function getProcessBy()
    {
        return $this->data['processBy'];
    }

    public function getUserDefined(int $rank = 1)
    {
        return $rank >= 0 && $rank <= 5 ? $this->data['userDefined' . $rank] : null;
    }

    public function getSubMerchantList()
    {
        return $this->data['subMerchantList'] ?? [];
    }

    public function getPaidAgent()
    {
        return $this->data['paidAgent'] ?? null;
    }

    public function getPaidChannel()
    {
        return $this->data['paidAgent'] ?? null;
    }

    protected function validateHashValue($data)
    {
        return strcmp(
            strtolower($data['hashValue'] ?? ''),
            strtolower($data['completedHashValue'] ?? '')
        ) == 0;
    }

    protected function hashValue($data)
    {
        $strToHash =
            $this->emptyIfNotFound($data, 'version') .
            $this->emptyIfNotFound($data, 'respCode') .
            $this->emptyIfNotFound($data, 'processType') .
            $this->emptyIfNotFound($data, 'invoiceNo') .
            $this->emptyIfNotFound($data, 'amount') .
            $this->emptyIfNotFound($data, 'status') .
            $this->emptyIfNotFound($data, 'approvalCode') .
            $this->emptyIfNotFound($data, 'referenceNo') .
            $this->emptyIfNotFound($data, 'transactionDateTime') .
            $this->emptyIfNotFound($data, 'paidAgent') .
            $this->emptyIfNotFound($data, 'paidChannel') .
            $this->emptyIfNotFound($data, 'maskedPan') .
            $this->emptyIfNotFound($data, 'eci') .
            $this->emptyIfNotFound(
                $this->sortListField($data, 'subMerchantList'), 'subMerchantList'
            ) .
            $this->emptyIfNotFound(
                $this->sortListField($data, 'refundList'), 'refundList'
            ) .
            $this->emptyIfNotFound($data, 'paymentScheme') .
            $this->emptyIfNotFound($data, 'processBy') .
            $this->emptyIfNotFound($data, 'refundReferenceNo') .
            $this->emptyIfNotFound($data, 'userDefined1') .
            $this->emptyIfNotFound($data, 'userDefined2') .
            $this->emptyIfNotFound($data, 'userDefined3') .
            $this->emptyIfNotFound($data, 'userDefined4') .
            $this->emptyIfNotFound($data, 'userDefined5')
        ;

        /** @var AbstractPaymentActionRequest $request */
        $request = $this->getRequest();

        return hash_hmac('sha1', $strToHash, $request->getSecretKey(), false);
    }
}
