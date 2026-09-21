<?php

namespace Inttegro\Otp;

/** Customer action protected by an OTP. */
enum Purpose: string
{
    /** Wire value: `account_creation`. */
    case AccountCreation = 'account_creation';

    /** Wire value: `account_recovery`. */
    case AccountRecovery = 'account_recovery';

    /** Wire value: `email_verification`. */
    case EmailVerification = 'email_verification';

    /** Wire value: `financial_account_verification`. */
    case FinancialAccountVerification = 'financial_account_verification';

    /** Wire value: `password_reset`. */
    case PasswordReset = 'password_reset';

    /** Wire value: `payment_confirmation`. */
    case PaymentConfirmation = 'payment_confirmation';

    /** Wire value: `payment_method_verification`. */
    case PaymentMethodVerification = 'payment_method_verification';

    /** Wire value: `payout_confirmation`. */
    case PayoutConfirmation = 'payout_confirmation';

    /** Wire value: `phone_verification`. */
    case PhoneVerification = 'phone_verification';

    /** Wire value: `sensitive_action`. */
    case SensitiveAction = 'sensitive_action';

    /** Wire value: `sign_in`. */
    case SignIn = 'sign_in';

    /** Wire value: `transaction_confirmation`. */
    case TransactionConfirmation = 'transaction_confirmation';

    /** Wire value: `unspecified`. */
    case Unspecified = 'unspecified';
}
