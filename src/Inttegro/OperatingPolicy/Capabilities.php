<?php

namespace Inttegro\OperatingPolicy;

/** Complete operating configuration selected for an application. */
final class Capabilities extends \Inttegro\DomainValue
{
    /** Payment configuration; PHP type: `PaymentsCapabilities|null`; wire field: `payments` (`object`). */
    public readonly ?PaymentsCapabilities $payments;
    /** Payout configuration; PHP type: `PayoutsCapabilities|null`; wire field: `payouts` (`object`). */
    public readonly ?PayoutsCapabilities $payouts;
    /** Payment-method configuration; PHP type: `PaymentMethodsCapabilities|null`; wire field: `payment_methods` (`object`). */
    public readonly ?PaymentMethodsCapabilities $paymentMethods;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->payments = \Inttegro\ValueHydrator::object($data['payments'] ?? null, [PaymentsCapabilities::class], true);
        $this->payouts = \Inttegro\ValueHydrator::object($data['payouts'] ?? null, [PayoutsCapabilities::class], true);
        $this->paymentMethods = \Inttegro\ValueHydrator::object($data['payment_methods'] ?? null, [PaymentMethodsCapabilities::class], true);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
