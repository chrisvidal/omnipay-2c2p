<?php
namespace Omnipay\CreditCardPaymentProcessor;

use Omnipay\Common\AbstractGateway;

/**
 * 2c2p Gateway Driver for Omnipay
 *
 * This driver is based on
 * 2c2p Redirect API documentation
 * @link https://developer.2c2p.com/docs/redirect-api-red
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'CreditCardPaymentProcessor';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'secretKey' => '',
            'publicKey' => '',
            'privateKey' => '',
            'pkcs7Password' => ''
        ];
    }

    public function sandbox()
    {
        return $this->setTestMode(true);
    }

    public function production()
    {
        return $this->setTestMode(false);
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($merchantId)
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setReturnUrl($returnUrl)
    {
        return $this->setParameter('returnUrl', $returnUrl);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter('notifyUrl');
    }

    public function setNotifyUrl($notifyUrl)
    {
        return $this->setParameter('notifyUrl', $notifyUrl);
    }

    public function getRefundNotifyUrl()
    {
        return $this->getParameter('refundNotifyUrl');
    }

    public function setRefundNotifyUrl($refundNotifyUrl)
    {
        return $this->setParameter('refundNotifyUrl', $refundNotifyUrl);
    }

    public function getTimeZone()
    {
        return $this->getParameter('timezone');
    }

    public function setTimeZone(\DateTimeZone $timeZone)
    {
        return $this->setParameter('timezone', $timeZone);
    }


    /** Only for redirect request */
    public function getDefaultLanguage()
    {
        return $this->getParameter('defaultLanguage');
    }

    public function setDefaultLanguage($language)
    {
        return $this->setParameter('defaultLanguage', $language);
    }

    public function getPaymentOption()
    {
        return $this->getParameter('paymentOption');
    }

    public function setPaymentOption($option)
    {
        return $this->setParameter('paymentOption', $option);
    }
    /** End */


    /** Only for payment action request */
    public function getPublicKey()
    {
        return $this->getParameter('publicKey');
    }

    public function setPublicKey($publicKey)
    {
        return $this->setParameter('publicKey', $publicKey);
    }

    public function getPrivateKey()
    {
        return $this->getParameter('privateKey');
    }

    public function setPrivateKey($privateKey)
    {
        return $this->setParameter('privateKey', $privateKey);
    }

    public function getPKCS7Password()
    {
        return $this->getParameter('pkcs7Password');
    }

    public function setPKCS7Password($password)
    {
        return $this->setParameter('pkcs7Password', $password);
    }

    public function getTempDir()
    {
        return $this->getParameter('tempDir');
    }

    public function setTempDir($dir)
    {
        return $this->setParameter('tempDir', $dir);
    }
    /** End */


    public function purchase(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\RedirectPurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\RedirectCompletePurchaseRequest::class, $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\PaymentActionSettleRequest::class, $parameters);
    }

    public function query(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\PaymentActionInquiryRequest::class, $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\PaymentActionRefundRequest::class, $parameters);
    }

    public function refundQuery(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\PaymentActionRefundQueryRequest::class, $parameters);
    }

    public function void(array $parameters = array())
    {
        return $this->createRequest(\Omnipay\CreditCardPaymentProcessor\Request\PaymentActionVoidRequest::class, $parameters);
    }

    public function supportsRefundQuery()
    {
        return method_exists($this, 'refundQuery');
    }
}
