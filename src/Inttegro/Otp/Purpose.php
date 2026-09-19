<?php

namespace Inttegro\Otp;

/** Customer action protected by an OTP. */
enum Purpose: string
{
    case AccountCreation = 'account_creation';
    case AccountRecovery = 'account_recovery';
    case EmailVerification = 'email_verification';
    case FinancialAccountVerification = 'financial_account_verification';
    case PasswordReset = 'password_reset';
    case PaymentConfirmation = 'payment_confirmation';
    case PaymentMethodVerification = 'payment_method_verification';
    case PayoutConfirmation = 'payout_confirmation';
    case PhoneVerification = 'phone_verification';
    case SensitiveAction = 'sensitive_action';
    case SignIn = 'sign_in';
    case TransactionConfirmation = 'transaction_confirmation';
    case Unspecified = 'unspecified';
}
