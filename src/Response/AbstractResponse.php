<?php

namespace Omnipay\CreditCardPaymentProcessor\Response;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;

abstract class AbstractResponse extends OmnipayAbstractResponse
{
    protected function implodeArray($data)
    {
        if (is_string($data)) {
            return $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->implodeArray($val);
            }
        }

        return implode('', array_values($data));
    }

    protected function emptyIfNotFound($haystack, $needle)
    {
        if (!isset($haystack[$needle])) {
            return '';
        }

        if (is_array($haystack[$needle])) {
            return $this->implodeArray($haystack[$needle]);
        }

        return $haystack[$needle];
    }

    protected function sortListField($haystack, $needle)
    {
        if (isset($haystack[$needle])) {
            if (is_array($list = $haystack[$needle])) {
                $array = [];
                switch ($needle) {
                    case 'subMerchantList':
                        $sortKey = ['subMID', 'subAmount'];
                        break;
                    case 'refundList':
                        $list = array_values($list['refund']);
                        $sortKey = [
                            'referenceNo', 'status', 'amount', 'dateTime', 'userDefined1', 'userDefined2',
                            'userDefined3', 'userDefined4', 'userDefined5'
                        ];
                        break;
                    default:
                        return $haystack;
                }

                foreach ($list as $item) {
                    $tmp = [];
                    foreach ($sortKey as $key) {
                        isset($item[$key]) && $tmp[$key] = $item[$key];
                    }
                    !empty($tmp) && array_push($array, $tmp);
                    unset($tmp);
                }

                if (!empty($array)) {
                    $haystack[$needle] = $array;
                }
            }
        }

        return $haystack;
    }
}
