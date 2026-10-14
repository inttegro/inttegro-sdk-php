<?php

namespace Inttegro\Payout;

/** Platform limits applied to payouts. */
final class SettingsLimits extends \Inttegro\DomainValue
{
    /**
     * Platform limits for payout amounts.
     *
     * Required response field. PHP type: `\Inttegro\Payout\AmountLimits`; wire field: `amount` (`object`).
     */
    public readonly \Inttegro\Payout\AmountLimits $amount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [\Inttegro\Payout\AmountLimits::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
