<?php

namespace Omnipay\CreditCardPaymentProcessor\Request;

abstract class AbstractRedirectRequest extends AbstractRequest
{
    const API_VERSION = '8.5';

    public function getUserDefined(int $rank = 1)
    {
        return $rank >= 0 && $rank <= 5 ? $this->getParameter('userDefined' . $rank) : null;
    }

    public function setUserDefined($value, int $rank = 1)
    {
        return $rank >= 0 && $rank <= 5 ? $this->setParameter('userDefined' . $rank, $value) : null;
    }

    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    public function setCustomerEmail($email)
    {
        return $this->setParameter('customerEmail', $email);
    }

    public function getPaymentOption()
    {
        return $this->getParameter('paymentOption');
    }

    public function setPaymentOption($option)
    {
        return $this->setParameter('paymentOption', $option);
    }

    public function getPaymentExpiry()
    {
        return $this->getParameter('paymentExpiry');
    }

    public function setPaymentExpiry(\DateTime $datetime)
    {
        return $this->setParameter('paymentExpiry', $datetime);
    }

    public function getDefaultLanguage()
    {
        return $this->getParameter('defaultLanguage');
    }

    public function setDefaultLanguage($language)
    {
        return $this->setParameter('defaultLanguage', $language);
    }

    public function getPayCategoryId()
    {
        return $this->getParameter('payCategoryId');
    }

    public function setPayCategoryId($payCategoryId)
    {
        return $this->setParameter('payCategoryId', $payCategoryId);
    }

    public function getAmountFormatted()
    {
        return str_pad($this->getAmountInteger(), 12, '0', STR_PAD_LEFT);
    }

    public function getPaymentExpiryFormatted()
    {
        $datetime = $this->getPaymentExpiry();
        if (!$datetime) {
            return null;
        }

        if (!($datetime instanceof \DateTime)) {
            if (!is_numeric($datetime)) {
                $datetime = strtotime($datetime);
            }
            $_datetime = new \DateTime();
            $_datetime->setTimestamp($datetime);
            $datetime = $_datetime;
        }

        if ($timezone = $this->getTimeZone()) {
            $datetime->setTimezone($timezone);
        }

        return $datetime->format('Y-m-d H:i:s');
    }

    public function getData()
    {
        $this->validate(
            'merchantId',
            'secretKey',
            'description',
            'transactionId',
            'amount',
            'currency'
        );

        $data = [
            'version' => $this->getVersion(),
            'merchant_id' => $this->getMerchantId(),
            'payment_description' => $this->getDescription(),
            'order_id' => $this->getTransactionId(),
            'amount' => $this->getAmountFormatted(),
            'currency' => is_numeric($this->getCurrency()) ? $this->getCurrency() : $this->getCurrencyNumeric()
        ];

        for ($i = 1; $i <= 5; $i++) {
            $data['user_defined_' . $i] = $this->getUserDefined($i);
        }

        return $data;
    }
}
