<?php

namespace Omnipay\CreditCardPaymentProcessor\Response;

class PaymentActionRefundResponse extends AbstractPaymentActionResponse
{
    public function getRefundList()
    {
        return $this->data['refundList'] ?? [];
    }

    public function parseRefundList(array $list)
    {
        foreach ($list as $i => $item) {
            isset($item['amount']) && $list[$i]['amount'] = floatval($item['amount']);
            if (isset($item['dateTime'])) {
                $datetime = \DateTime::createFromFormat('YmdHis', $item['dateTime'], $this->request->getTimeZone());
                $list[$i]['timestamp'] = $datetime->getTimestamp();
            }
        }

        return $list;
    }

    public function getAndParseRefundList()
    {
        return $this->parseRefundList($this->getRefundList());
    }


//array(23) {
//    ["version"]=>
//    string(3) "3.4"
//    ["timeStamp"]=>
//    string(12) "140120085909"
//    ["respCode"]=>
//    string(2) "00"
//    ["hashValue"]=>
//    string(40) "aa70e458fbe862b785dcbb7566171c0f937deb74"
//    ["respDesc"]=>
//    string(7) "Success"
//    ["processType"]=>
//    string(1) "R"
//    ["invoiceNo"]=>
//    string(19) "2020010715420012345"
//    ["amount"]=>
//    string(4) "1.00"
//    ["status"]=>
//    string(2) "RF"
//    ["approvalCode"]=>
//    string(6) "774498"
//    ["referenceNo"]=>
//    string(7) "2587151"
//    ["refundReferenceNo"]=>
//    string(7) "2594993"
//    ["transactionDateTime"]=>
//    string(14) "20200107144618"
//    ["maskedPan"]=>
//    string(16) "411111XXXXXX1111"
//    ["eci"]=>
//    string(2) "05"
//    ["paymentScheme"]=>
//    string(2) "VI"
//    ["processBy"]=>
//    string(2) "VI"
//    ["userDefined1"]=>
//    string(0) ""
//    ["userDefined2"]=>
//    string(0) ""
//    ["userDefined3"]=>
//    string(0) ""
//    ["userDefined4"]=>
//    string(0) ""
//    ["userDefined5"]=>
//    string(0) ""
//    ["completedHashValue"]=>
//    string(40) "aa70e458fbe862b785dcbb7566171c0f937deb74"
//}
}
