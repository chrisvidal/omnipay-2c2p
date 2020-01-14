<?php

namespace Omnipay\CreditCardPaymentProcessor\Common;

final class PaymentActionReference
{
    const
        RESULT_SUCCESS = '00', // Success
        RESULT_INVALID_HASH = '13' // Invalid hash value
    ;

    const
        PROCESS_INQUIRY = 'I', // Inquiry
        PROCESS_SETTLEMENT = 'S', // Settlement
        PROCESS_VOID = 'V', // Void/Cancel
        PROCESS_REFUND = 'R', // Refund
        PROCESS_REFUND_STATUS = 'RS' // Refund Status
    ;

    const
        STATUS_APPROVED = 'A', // Approved
        STATUS_APPROVAL_PENDING = 'AP', // Approval Pending (APM)
        STATUS_APPROVED_AFTER_EXPIRED = 'AE', // Approved after Expired (APM)
        STATUS_APPROVED_LESS_AMOUNT = 'AL', // Approved with less amount (APM)
        STATUS_APPROVED_MORE_AMOUNT = 'AM', // Approved with more amount (APM)
        STATUS_FAILED = 'PF', // Payment Failed
        STATUS_AUTH_REJECTED = 'AR', // Authentication Rejected (MPI Reject)
        STATUS_FRAUD_RULE_REJECTED = 'FF', // Fraud Rule Rejected
        STATUS_REJECTED_WITH_INVALID_PROMOTION = 'IP', // Rejected (Invalid Promotion)
        STATUS_REJECTED_BY_ROUTING = 'ROE', // Rejected (Routing Rejected)
        STATUS_REFUND_PENDING = 'RP', // Refund Pending
        STATUS_REFUND_CONFIRMED = 'RF', // Refund confirmed
        STATUS_REFUND_REJECTED = 'RR', // Refund Rejected
        STATUS_REFUND_REJECTED_WITH_INSUFFICIENT_BALANCE = 'RR1', // Refund Rejected – insufficient balance
        STATUS_REFUND_REJECTED_WITH_INVALID_BANK_INFO = 'RR2', // Refund Rejected – invalid bank information
        STATUS_REFUND_REJECTED_WITH_BANK_ACCOUNT_MISMATCH = 'RR3', // Refund Rejected – bank account mismatch
        STATUS_READY_SETTLE = 'RS', // Ready for Settlement
        STATUS_SETTLED = 'S', // Settled
        STATUS_CREDIT_ADJUSTMENT = 'T', // Credit Adjustment
        STATUS_VOIDED = 'V', // Voided / Canceled
        STATUS_VOID_PENDING = 'VP' // Void Pending
    ;

    const
        AGENT_BBL = 'BBL', // Bangkok Bank
        AGENT_KBANK = 'KBANK', // Kasikorn Bank
        AGENT_KTB = 'KTB', // Krung Thai Bank
        AGENT_SCB = 'SCB', // Siam Commercial Bank
        AGENT_TBANK = 'TBANK', // Thanachart Bank Public Company Ltd.
        AGENT_UOB = 'UOB', // United Overseas Bank
        AGENT_CIMB = 'CIMB', // CIMB Thai Bank Public Company Ltd.
        AGENT_TMB = 'TMB', // TMB Bank Public Company Limited
        AGENT_BAY = 'BAY', // Bank of Ayutthaya
        AGENT_TRUE_MONEY = 'TRUEMONEY', // True Money Shop
        AGENT_TESCO = 'TESCO', // Tesco Lotus Counter Service
        AGENT_TOT = 'TOT', // Just Pay by TOT public Company Ltd.
        AGENT_PAP = 'PAP' // Pay at post
    ;

    const
        CHANNEL_ATM = 'ATM', // ATM machines
        CHANNEL_BANK_COUNTER = 'BANKCOUNTER', // Bank branch counters
        CHANNEL_IBANKING_TRANSFER = 'IBANKING', // Internet banking transfer
        CHANNEL_WEB_PAY = 'WEBPAY', // Bank’s Ibanking website
        CHANNEL_OVER_THE_COUNTER = 'OVERTHECOUNTER', // Over the counter (convenient stores, bank counter)
        CHANNEL_KIOSK = 'KIOSK' // KIOSK machines
    ;

    const
        SCHEME_VISA = 'VI', // VISA
        SCHEME_MASTER_CARD = 'MA', // MASTER CARD
        SCHEME_JCB = 'JC', // JCB
        SCHEME_AMEX = 'AM', // AMEX
        SCHEME_DINNER = 'DN', // DINNER
        SCHEME_DISCOVER = 'DI', // DISCOVER
        SCHEME_UNIONPAY = 'UP', // CHINA UNION PAY
        SCHEME_MPU = 'MP', // MPU
        SCHEME_ALIPAY = 'AL', // ALIPAY
        SCHEME_LINEPAY = 'LP', // LINEPAY
        SCHEME_PAYPAL = 'PA', // PAYPAL
        SCHEME_WECHATPAY = 'WC', // WECHAT
        SCHEME_KCP = 'KP', // KCP
        SCHEME_ALTERNATIVE = 'AP' // ALTERNATIVE PAYMENT
    ;
}
