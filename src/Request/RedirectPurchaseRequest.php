<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

use Omnipay\CreditCardPaymentProcessor\Response\RedirectPurchaseResponse;

class RedirectPurchaseRequest extends AbstractRedirectRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data = $this->mergeData($data, [
            'customer_email' => $this->getCustomerEmail(),
            'result_url_1' => $this->getReturnUrl(),
            'result_url_2' => $this->getNotifyUrl(),
            'payment_option' => $this->getPaymentOption(),
            'payment_expiry' => $this->getPaymentExpiryFormatted(),
            'default_lang' => $this->getDefaultLanguage(),
            'sub_merchant_list' => null, // base64_encode(json_encode([]))
            'airline_passenger_list' => null // base64_encode(json_encode([]))
        ]);

        $data = $this->filterData($data);

        $data['hash_value'] = $this->hashValue($data);

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new RedirectPurchaseResponse($this, $data);
    }

    protected function hashValue($data)
    {
        $strToHash =
            $this->emptyIfNotFound($data, 'version') .
            $this->emptyIfNotFound($data, 'merchant_id') .
            $this->emptyIfNotFound($data, 'payment_description') .
            $this->emptyIfNotFound($data, 'order_id') .
            $this->emptyIfNotFound($data, 'invoice_no') .
            $this->emptyIfNotFound($data, 'currency') .
            $this->emptyIfNotFound($data, 'amount') .
            $this->emptyIfNotFound($data, 'customer_email') .
            $this->emptyIfNotFound($data, 'pay_category_id') .
            $this->emptyIfNotFound($data, 'promotion') .
            $this->emptyIfNotFound($data, 'user_defined_1') .
            $this->emptyIfNotFound($data, 'user_defined_2') .
            $this->emptyIfNotFound($data, 'user_defined_3') .
            $this->emptyIfNotFound($data, 'user_defined_4') .
            $this->emptyIfNotFound($data, 'user_defined_5') .
            $this->emptyIfNotFound($data, 'result_url_1') .
            $this->emptyIfNotFound($data, 'result_url_2') .
            $this->emptyIfNotFound($data, 'enable_store_card') .
            $this->emptyIfNotFound($data, 'stored_card_unique_id') .
            $this->emptyIfNotFound($data, 'request_3ds') .
            $this->emptyIfNotFound($data, 'recurring') .
            $this->emptyIfNotFound($data, 'order_prefix') .
            $this->emptyIfNotFound($data, 'recurring_amount') .
            $this->emptyIfNotFound($data, 'allow_accumulate') .
            $this->emptyIfNotFound($data, 'max_accumulate_amount') .
            $this->emptyIfNotFound($data, 'recurring_interval') .
            $this->emptyIfNotFound($data, 'recurring_count') .
            $this->emptyIfNotFound($data, 'charge_next_date') .
            $this->emptyIfNotFound($data, 'charge_on_date') .
            $this->emptyIfNotFound($data, 'payment_option') .
            $this->emptyIfNotFound($data, 'ipp_interest_type') .
            $this->emptyIfNotFound($data, 'payment_expiry') .
            $this->emptyIfNotFound($data, 'default_lang') .
            $this->emptyIfNotFound($data, 'statement_descriptor') .
            $this->emptyIfNotFound($data, 'use_storedcard_only') .
            $this->emptyIfNotFound($data, 'tokenize_without_authorization') .
            $this->emptyIfNotFound($data, 'product') .
            $this->emptyIfNotFound($data, 'ipp_period_filter') .
            $this->emptyIfNotFound($data, 'sub_merchant_list') .
            $this->emptyIfNotFound($data, 'qr_type') .
            $this->emptyIfNotFound($data, 'custom_route_id') .
            $this->emptyIfNotFound($data, 'airline_transaction') .
            $this->emptyIfNotFound($data, 'airline_passenger_list') .
            $this->emptyIfNotFound($data, 'address_list')
        ;

        return hash_hmac('sha256', $strToHash, $this->getSecretKey(), false);
    }
}
