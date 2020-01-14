<?php

namespace Omnipay\CreditCardPaymentProcessor\Common;

final class RedirectReference
{
    const
        OPTION_ALL = 'A', // All available options (default)
        OPTION_ONLY_CREDIT_CARD_AND_IPP = 'B', // Credit card and IPP (Installment Payment Plan) ONLY
        OPTION_ONLY_CREDIT_CARD = 'C', // Credit card payment only
        OPTION_ONLY_FULL_AMOUNT = 'F', // Full amount payment ONLY
        OPTION_ONLY_IPP = 'I', // IPP (Installment Payment Plan) payment ONLY
        OPTION_ONLY_KCP = 'K', // KCP payment ONLY
        OPTION_ONLY_ALIPAY = 'L', // Alipay payment ONLY
        OPTION_ONLY_MPU = 'M', // MPU payment ONLY
        OPTION_ONLY_PAYPAL = 'P', // Paypal payment ONLY
        OPTION_ONLY_SAMSUNG_PAY = 'S', // Samsung Pay ONLY
        OPTION_ONLY_UNIONPAY = 'U', // Unionpay payment ONLY
        OPTION_ONLY_WECHATPAY = 'W', // WeChat payment ONLY
        OPTION_ONLY_APM = '1', // 1-2-3 (APM) payment ONLY
        OPTION_ONLY_EMV_QR_PAY = 'E' // EMV QR Payments ONLY
    ;

    const
        LANGUAGE_EN = 'en', // English (default)
        LANGUAGE_ZH = 'zh', // Simplified Chinese
        LANGUAGE_TH = 'th', // Thai
        LANGUAGE_ID = 'id', // Bahasa Indonesia
        LANGUAGE_JA = 'ja', // Japanese
        LANGUAGE_MY = 'my', // Burmese
        LANGUAGE_VI = 'vi' // Vietnamese
    ;

    const
        CHANNEL_CREDIT_AND_DEBIT_CARD = '001', // Credit and debit cards
        CHANNEL_CASH = '002', // Cash payment channel
        CHANNEL_DIRECT_DEBIT = '003', // Direct debit
        CHANNEL_OTHERS = '004', // Others
        CHANNEL_IPP = '005' // IPP transaction
    ;

    const
        STATUS_SUCCESS = '000', // Payment Successful
        STATUS_PENDING = '001', // Payment Pending
        STATUS_REJECTED = '002', // Payment Rejected
        STATUS_USER_CANCELED = '003', // Payment was canceled by user
        STATUS_FAILED = '999', // Payment Failed
        STATUS_INVALID_HASH = '1000' // Invalid response hash value
    ;

    const
        SCHEME_ALIPAY = 'AL', // ALIPAY
        SCHEME_AMEX = 'AM', // AMEX
        SCHEME_ALTERNATIVE = 'AP', // ALTERNATIVE PAYMENT
        SCHEME_DISCOVER = 'DI', // DISCOVER
        SCHEME_DINNER = 'DN', // DINNER
        SCHEME_JCB = 'JC', // JCB
        SCHEME_KCP = 'KP', // KCP
        SCHEME_LINEPAY = 'LP', // LINEPAY
        SCHEME_MASTER_CARD = 'MA', // MASTER CARD
        SCHEME_MPU = 'MP', // MPU
        SCHEME_PAYPAL = 'PA', // PAYPAL
        SCHEME_UNIONPAY = 'UP', // CHINA UNION PAY
        SCHEME_VISA = 'VI', // VISA
        SCHEME_WECHATPAY = 'WC', // WECHAT
        SCHEME_QR_GATEWAY = 'EQ', // QR Gateway
        SCHEME_QR_GATEWAY_VISA = 'EVI', // QR Gateway - VISA
        SCHEME_QR_GATEWAY_MASTER = 'EMA', // QR Gateway - MASTER
        SCHEME_QR_GATEWAY_THAI = 'ETQ' // QR Gateway - Thai QR
    ;

    public static $paymentStatusMessages = [
        self::STATUS_SUCCESS => 'Payment Successful (Paid)',
        self::STATUS_PENDING => 'Payment Pending (Waiting customer to pay)',
        self::STATUS_REJECTED => 'Payment Rejected (Failed payment)',
        self::STATUS_USER_CANCELED => 'Payment was canceled by user (Failed payment)',
        self::STATUS_FAILED => 'Error (Failed payment)',
        self::STATUS_INVALID_HASH => 'Invalid hash value'
    ];
}
