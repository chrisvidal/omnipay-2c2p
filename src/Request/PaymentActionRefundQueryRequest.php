<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Common\PaymentActionReference;
use Omnipay\CreditCardPaymentProcessor\Response\PaymentActionRefundQueryResponse;

class PaymentActionRefundQueryRequest extends AbstractPaymentActionRequest
{
    protected $processType = PaymentActionReference::PROCESS_REFUND_STATUS;

    public function getData()
    {
        $data = parent::getData();

        $data = $this->filterData($data);

        $data['hashValue'] = strtoupper($this->hashValue($data));

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentActionRefundQueryResponse($this, parent::sendData($data));
    }
}
