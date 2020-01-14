<?php

namespace Omnipay\CreditCardPaymentProcessor\Common;

use SimpleXMLElement;
use DOMDocument;

class XMLHelper
{
    public static function getXmlFromArray($value, SimpleXMLElement &$xmlElement, $entity, $starting = null)
    {
        $handleValue = function ($value) {
            if (is_string($value)) {
                $value = htmlspecialchars($value);
            }
            return $value;
        };

        $addChild = function ($name, $value, &$subNode = null) use (&$xmlElement, $handleValue, $entity) {
            if (is_array($value)) {
                if (!$subNode instanceof SimpleXMLElement) {
                    $currentKey = key($value);
                    $initialValue = null;
                    if (is_numeric($currentKey)) {
                        if (!is_array($value[$currentKey])) {
                            $initialValue = $value[$currentKey];
                            unset($value[$currentKey]);
                        }
                    }
                    $subNode = $xmlElement->addChild($name, $initialValue);
                }
                self::getXmlFromArray($handleValue($value), $subNode, $name);
            } else {
                $xmlElement->addChild($name, $handleValue($value));
            }
        };

        if (is_array($value)) {
            if (is_numeric(key($value))) {
                $setSubNodePrimitiveValue = function ($value) use (&$xmlElement, $entity, $handleValue) {
                    $value = $handleValue($value);
                    $children = $xmlElement->children();
                    $children[] = $value;
                };
                foreach ($value as $item) {
                    if (!is_array($item)) {
                        $setSubNodePrimitiveValue($item);
                    } else {
                        if ($starting === true) {
                            $addChild($entity, $item);
                        } else {
                            $addChild($entity, $item, $xmlElement);
                        }
                    }
                }
            } else {
                foreach ($value as $subEntity => $subEntityItem) {
                    $addChild($subEntity, $subEntityItem);
                }
            }
        } else {
            $xmlElement->addChild($entity, $handleValue($value));
        }
    }

    /**
     * @param array $array
     * @param string $openingTag
     * @param string $entity
     * @param string $nameSpace
     * @param bool $isPrefixed
     * @return SimpleXMLElement
     */
    public static function generateXmlFromArray(array $array, string $openingTag, string $entity, $nameSpace = '', $isPrefixed = false)
    {
        $xmlString = '<'.$openingTag.'></'.$openingTag.'>';
        $xml = new SimpleXMLElement($xmlString, LIBXML_NOERROR, false, $nameSpace, $isPrefixed);
        self::getXmlFromArray($array, $xml, $entity, true);
        return $xml;
    }

    /**
     * @param string $xml
     * @return bool
     */
    public static function validateXml(string $xml)
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        return $dom->validate();
    }

    public static function loadXmlPathAsArray(string $xmlPath)
    {
        $xml = simplexml_load_file($xmlPath);
        $array = json_decode(json_encode($xml), true);
        return (array)$array;
    }

    /**
     * @param string $xmlString
     * @return array
     */
    public static function loadXmlStringAsArray(string $xmlString)
    {
        return self::decodeXmlToArray(simplexml_load_string($xmlString));
    }

    protected static function decodeXmlToArray($mixed)
    {
        if (is_object($mixed)) {
            $mixed = get_object_vars($mixed);
        }

        if (is_array($mixed)) {
            foreach ($mixed as $key => $val) {
                $mixed[$key] = self::decodeXmlToArray($val);
            }
        }

        return $mixed;
    }

    /**
     * @param string $xmlString
     * @return SimpleXMLElement
     */
    public static function loadXmlString(string $xmlString)
    {
        return simplexml_load_string($xmlString);
    }
}
