<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Response\RedirectCompletePurchaseResponse;

class RedirectCompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = $this->httpRequest->request->all();

        $data['hash_value'] = strtolower($data['hash_value'] ?? '');
        $data['completed_hash_value'] = strtolower($this->hashValue($data));

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new RedirectCompletePurchaseResponse($this, $data);
    }

    protected function hashValue($data)
    {
        $strToHash =
            $this->emptyIfNotFound($data, 'version') .
            $this->emptyIfNotFound($data, 'request_timestamp') .
            $this->emptyIfNotFound($data, 'merchant_id') .
            $this->emptyIfNotFound($data, 'order_id') .
            $this->emptyIfNotFound($data, 'invoice_no') .
            $this->emptyIfNotFound($data, 'currency') .
            $this->emptyIfNotFound($data, 'amount') .
            $this->emptyIfNotFound($data, 'transaction_ref') .
            $this->emptyIfNotFound($data, 'approval_code') .
            $this->emptyIfNotFound($data, 'eci') .
            $this->emptyIfNotFound($data, 'transaction_datetime') .
            $this->emptyIfNotFound($data, 'payment_channel') .
            $this->emptyIfNotFound($data, 'payment_status') .
            $this->emptyIfNotFound($data, 'channel_response_code') .
            $this->emptyIfNotFound($data, 'channel_response_desc') .
            $this->emptyIfNotFound($data, 'masked_pan') .
            $this->emptyIfNotFound($data, 'stored_card_unique_id') .
            $this->emptyIfNotFound($data, 'backend_invoice') .
            $this->emptyIfNotFound($data, 'paid_channel') .
            $this->emptyIfNotFound($data, 'paid_agent') .
            $this->emptyIfNotFound($data, 'recurring_unique_id') .
            $this->emptyIfNotFound($data, 'user_defined_1') .
            $this->emptyIfNotFound($data, 'user_defined_2') .
            $this->emptyIfNotFound($data, 'user_defined_3') .
            $this->emptyIfNotFound($data, 'user_defined_4') .
            $this->emptyIfNotFound($data, 'user_defined_5') .
            $this->emptyIfNotFound($data, 'browser_info') .
            $this->emptyIfNotFound($data, 'ippPeriod') .
            $this->emptyIfNotFound($data, 'ippInterestType') .
            $this->emptyIfNotFound($data, 'ippInterestRate') .
            $this->emptyIfNotFound($data, 'ippMerchantAbsorbRate') .
            $this->emptyIfNotFound($data, 'payment_scheme') .
            $this->emptyIfNotFound($data, 'process_by') .
            $this->emptyIfNotFound($data, 'sub_merchant_list');

        return hash_hmac('sha256', $strToHash, $this->getSecretKey(), false);
    }
}
