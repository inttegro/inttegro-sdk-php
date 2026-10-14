<?php

namespace Inttegro\Payout;

/** Inclusive payout amount range. */
final class AmountLimits extends \Inttegro\DomainValue
{
    /**
     * Smallest payout amount accepted by the platform.
     *
     * Required response field. PHP type: `\Inttegro\Money\Amount`; wire field: `min` (`object`).
     */
    public readonly \Inttegro\Money\Amount $min;

    /**
     * Largest payout amount accepted by the platform.
     *
     * Required response field. PHP type: `\Inttegro\Money\Amount`; wire field: `max` (`object`).
     */
    public readonly \Inttegro\Money\Amount $max;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->min = \Inttegro\ValueHydrator::object($data['min'] ?? null, [\Inttegro\Money\Amount::class], false);
        $this->max = \Inttegro\ValueHydrator::object($data['max'] ?? null, [\Inttegro\Money\Amount::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
