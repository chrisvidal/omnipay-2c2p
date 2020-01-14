<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Common\PaymentActionReference;
use Omnipay\CreditCardPaymentProcessor\Response\PaymentActionSettleResponse;

class PaymentActionSettleRequest extends AbstractPaymentActionRequest
{
    protected $processType = PaymentActionReference::PROCESS_SETTLEMENT;

    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount');

        $data = $this->mergeData($data, [
            'actionAmount' => $this->getAmount()
        ]);

        $data = $this->filterData($data);

        $data['hashValue'] = strtoupper($this->hashValue($data));

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PaymentActionSettleResponse($this, parent::sendData($data));
    }
}
