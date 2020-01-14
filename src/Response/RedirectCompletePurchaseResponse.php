<?php

namespace Omnipay\CreditCardPaymentProcessor\Response;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\CreditCardPaymentProcessor\Common\RedirectReference;

class RedirectCompletePurchaseResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        if (strcmp($this->data['hash_value'], $this->data['completed_hash_value']) != 0) {
            $this->data['payment_status'] = RedirectReference::STATUS_INVALID_HASH;
        }
    }

    public function isSuccessful()
    {
        return ($this->data['payment_status'] ?? null) == RedirectReference::STATUS_SUCCESS;
    }

    public function isPending()
    {
        return ($this->data['payment_status'] ?? null) == RedirectReference::STATUS_PENDING;
    }

    public function isCancelled()
    {
        return ($this->data['payment_status'] ?? null) == RedirectReference::STATUS_USER_CANCELED;
    }

    public function getMessage()
    {
        return RedirectReference::$paymentStatusMessages[$this->data['payment_status']] ?? '';
    }

    public function getTransactionReference()
    {
        return $this->data['transaction_ref'];
    }

    public function getTransactionId()
    {
        return $this->data['order_id'];
    }

    public function getVersion()
    {
        return $this->data['version'];
    }

    public function getRequestTimestamp()
    {
        if (!isset($this->data['request_timestamp']))
            return 0;

        $datetime = new \DateTime($this->data['request_timestamp'], $this->request->getTimeZone());
        return $datetime->getTimestamp();
    }

    public function getMerchantId()
    {
        return $this->data['merchant_id'];
    }

    /**
     * @deprecated
     */
    public function getInvoiceNo()
    {
        return $this->data['invoice_no'];
    }

    public function getCurrencyNumeric()
    {
        return $this->data['currency'];
    }

    public function getAmount() : float
    {
        if (!isset($this->data['amount']))
            return 0;

        return intval(ltrim('0', $this->data['amount'])) / 100;
    }

    public function getApprovalCode()
    {
        return $this->data['approval_code'];
    }

    public function getECI()
    {
        return $this->data['eci'];
    }

    public function getTransactionTimestamp()
    {
        if (!isset($this->data['transaction_datetime']))
            return 0;

        $datetime = new \DateTime($this->data['transaction_datetime'], $this->request->getTimeZone());
        return $datetime->getTimestamp();
    }

    public function getPaymentChannel()
    {
        return $this->data['payment_channel'];
    }

    public function getPaymentStatus()
    {
        return $this->data['payment_status'];
    }

    public function getChannelResponseCode()
    {
        return $this->data['channel_response_code'];
    }

    public function getChannelResponseDescription()
    {
        return $this->data['channel_response_desc'];
    }

    public function getMaskedPan()
    {
        return $this->data['masked_pan'];
    }

    public function getStoredCardUniqueId()
    {
        return $this->data['stored_card_unique_id'];
    }

    public function getBackendInvoice()
    {
        return $this->data['backend_invoice'];
    }

    public function getPaidChannel()
    {
        return $this->data['paid_channel'];
    }

    public function getPaidAgent()
    {
        return $this->data['paid_agent'];
    }

    public function getRecurringUniqueId()
    {
        return $this->data['recurring_unique_id'];
    }

    public function getIppPeriod()
    {
        return $this->data['ippPeriod'];
    }

    public function getIppInterestType()
    {
        return $this->data['ippInterestType'];
    }

    public function getIppInterestRate()
    {
        return $this->data['ippInterestRate'];
    }

    public function getIppMerchantAbsorbRate()
    {
        return $this->data['ippMerchantAbsorbRate'];
    }

    public function getPaymentScheme()
    {
        return $this->data['payment_scheme'];
    }

    public function getProcessBy()
    {
        return $this->data['process_by'];
    }

    public function getSubMerchantList()
    {
        return $this->data['sub_merchant_list'];
    }

    public function getUserDefined(int $rank = 1)
    {
        return $rank >= 0 && $rank <= 5 ? $this->data['user_defined_' . $rank] : null;
    }

    public function getBrowserInfo()
    {
        return $this->data['browser_info'];
    }

    public function getMcp()
    {
        return $this->data['mcp'];
    }

    public function getMcpAmount()
    {
        return $this->data['mcp_amount'];
    }

    public function getMcpCurrency()
    {
        return $this->data['mcp_currency'];
    }

    public function getMcpExchangeRate()
    {
        return $this->data['mcp_exchange_rate'];
    }

//array(40) {
//    ["version"]=>
//    string(3) "8.5"
//    ["request_timestamp"]=>
//    string(19) "2020-01-07 13:19:34"
//    ["merchant_id"]=>
//    string(4) "JT04"
//    ["currency"]=>
//    string(3) "764"
//    ["order_id"]=>
//    string(19) "2020010712140012345"
//    ["amount"]=>
//    string(12) "000000000100"
//    ["invoice_no"]=>
//    string(0) ""
//    ["transaction_ref"]=>
//    string(19) "2020010712140012345"
//    ["approval_code"]=>
//    string(6) "055078"
//    ["eci"]=>
//    string(2) "05"
//    ["transaction_datetime"]=>
//    string(19) "2020-01-07 13:20:45"
//    ["payment_channel"]=>
//    string(3) "001"
//    ["payment_status"]=>
//    string(3) "000"
//    ["channel_response_code"]=>
//    string(2) "00"
//    ["channel_response_desc"]=>
//    string(7) "success"
//    ["masked_pan"]=>
//    string(16) "411111XXXXXX1111"
//    ["stored_card_unique_id"]=>
//    string(0) ""
//    ["backend_invoice"]=>
//    string(0) ""
//    ["paid_channel"]=>
//    string(0) ""
//    ["paid_agent"]=>
//    string(0) ""
//    ["recurring_unique_id"]=>
//    string(0) ""
//    ["ippPeriod"]=>
//    string(0) ""
//    ["ippInterestType"]=>
//    string(0) ""
//    ["ippInterestRate"]=>
//    string(0) ""
//    ["ippMerchantAbsorbRate"]=>
//    string(0) ""
//    ["payment_scheme"]=>
//    string(2) "VI"
//    ["process_by"]=>
//    string(2) "VI"
//    ["sub_merchant_list"]=>
//    string(0) ""
//    ["user_defined_1"]=>
//    string(19) "2020010712140012345"
//    ["user_defined_2"]=>
//    string(0) ""
//    ["user_defined_3"]=>
//    string(0) ""
//    ["user_defined_4"]=>
//    string(0) ""
//    ["user_defined_5"]=>
//    string(0) ""
//    ["browser_info"]=>
//    string(34) "Type=Chrome79,Name=Chrome,Ver=79.0"
//    ["mcp"]=>
//    string(0) ""
//    ["mcp_amount"]=>
//    string(0) ""
//    ["mcp_currency"]=>
//    string(0) ""
//    ["mcp_exchange_rate"]=>
//    string(0) ""
//    ["hash_value"]=>
//    string(64) "bc00298e8cfca6c966c9a8c392aff43a0614e7803909e84736c74ba02a1231c5"
//    ["completed_hash_value"]=>
//    string(64) "bc00298e8cfca6c966c9a8c392aff43a0614e7803909e84736c74ba02a1231c5"
//}
}
