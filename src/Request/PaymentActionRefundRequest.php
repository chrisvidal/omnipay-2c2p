<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Common\PaymentActionReference;
use Omnipay\CreditCardPaymentProcessor\Response\PaymentActionRefundResponse;

class PaymentActionRefundRequest extends AbstractPaymentActionRequest
{
    protected $processType = PaymentActionReference::PROCESS_REFUND;

    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount', 'refundNotifyUrl');

        $data = $this->mergeData($data, [
            'actionAmount' => $this->getAmount(),
            'notifyURL' => $this->getRefundNotifyUrl(),

            /** Only applicable to APM transaction Refund request */
            'bankCode' => $this->getBankCode(),
            'accountName' => $this->getAccountName(),
            'accountNumber' => $this->getAccountNumber(),

            /** Only applicable to MasterMerchant Account */
            'subMerchantList' => null
        ]);

        $data = $this->filterData($data);

        $data['hashValue'] = strtoupper($this->hashValue($data));

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentActionRefundResponse($this, parent::sendData($data));
    }

    public function getBankCode()
    {
        return $this->getParameter('bankCode');
    }

    public function setBankCode($bankCode)
    {
        return $this->setParameter('bankCode', $bankCode);
    }

    public function getAccountName()
    {
        return $this->getParameter('accountName');
    }

    public function setAccountName($accountName)
    {
        return $this->setParameter('accountName', $accountName);
    }

    public function getAccountNumber()
    {
        return $this->getParameter('accountNumber');
    }

    public function setAccountNumber($accountNumber)
    {
        return $this->setParameter('accountNumber', $accountNumber);
    }
}
