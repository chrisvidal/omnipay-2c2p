<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Common\PaymentActionReference;
use Omnipay\CreditCardPaymentProcessor\Response\PaymentActionVoidResponse;

class PaymentActionVoidRequest extends AbstractPaymentActionRequest
{
    protected $processType = PaymentActionReference::PROCESS_VOID;

    public function getData()
    {
        $data = parent::getData();

        $data = $this->filterData($data);

        $data['hashValue'] = strtoupper($this->hashValue($data));

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentActionVoidResponse($this, parent::sendData($data));
    }
}
