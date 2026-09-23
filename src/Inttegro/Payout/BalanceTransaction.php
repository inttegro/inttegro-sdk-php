<?php

namespace Inttegro\Payout;

use Inttegro\Money\Amount;

/** A sparse view of one balance transaction's contribution to a payout. */
final class BalanceTransaction extends \Inttegro\DomainValue
{
    /**
     * The exact portion allocated to this payout.
     *
     * Required response field. PHP type: `Amount`; wire field: `allocated_amount`
     * (`object`).
     *
     * @var Amount
     */
    public readonly Amount $allocatedAmount;

    /**
     * The balance transaction's original amount before allocations.
     *
     * Required response field. PHP type: `Amount`; wire field: `amount` (`object`).
     *
     * @var Amount
     */
    public readonly Amount $amount;

    /**
     * Unique balance transaction identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->allocatedAmount = \Inttegro\ValueHydrator::object(
            $data['allocated_amount'] ?? null,
            [Amount::class],
            false,
        );
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [Amount::class], false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
