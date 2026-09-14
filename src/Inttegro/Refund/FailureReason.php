<?php

namespace Inttegro\Refund;

/** Stable, caller-safe reasons that terminal refund processing failed. */
enum FailureReason: string
{
    /** Wire value: `insufficient_balance`. */
    case InsufficientBalance = 'insufficient_balance';
    /** Wire value: `original_payment_method_unavailable`. */
    case OriginalPaymentMethodUnavailable = 'original_payment_method_unavailable';
    /** Wire value: `original_payment_not_refundable`. */
    case OriginalPaymentNotRefundable = 'original_payment_not_refundable';
    /** Wire value: `refund_not_supported`. */
    case RefundNotSupported = 'refund_not_supported';
    /** Wire value: `amount_not_supported`. */
    case AmountNotSupported = 'amount_not_supported';
    /** Wire value: `refund_declined`. */
    case RefundDeclined = 'refund_declined';
    /** Wire value: `refund_not_permitted`. */
    case RefundNotPermitted = 'refund_not_permitted';
    /** Wire value: `temporarily_unavailable`. */
    case TemporarilyUnavailable = 'temporarily_unavailable';
    /** Wire value: `unknown`. */
    case Unknown = 'unknown';
}
