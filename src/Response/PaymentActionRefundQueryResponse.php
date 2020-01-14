<?php

namespace Omnipay\CreditCardPaymentProcessor\Response;

class PaymentActionRefundQueryResponse extends AbstractPaymentActionResponse
{
    public function getRefundList()
    {
        return array_values($this->data['refundList']['refund'] ?? []);
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
}
