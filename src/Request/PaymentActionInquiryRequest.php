<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Common\PaymentActionReference;
use Omnipay\CreditCardPaymentProcessor\Response\PaymentActionInquiryResponse;

class PaymentActionInquiryRequest extends AbstractPaymentActionRequest
{
    protected $processType = PaymentActionReference::PROCESS_INQUIRY;

    public function getData()
    {
        $data = parent::getData();

        $data = $this->filterData($data);

        $data['hashValue'] = strtoupper($this->hashValue($data));

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentActionInquiryResponse($this, parent::sendData($data));
    }
}
