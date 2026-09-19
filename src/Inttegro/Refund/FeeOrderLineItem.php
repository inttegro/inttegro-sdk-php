<?php

namespace Inttegro\Refund;

/** Immutable fee order-line snapshot attached to a refund. */
final class FeeOrderLineItem extends \Inttegro\DomainValue
{
    /**
     * Immutable order-line identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Discriminator identifying this snapshot as a fee line.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`, always `fee`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Fee label and description captured on the order.
     *
     * Required response field. PHP type: `OrderLineItemAdjustment`; wire field: `fee` (`object`).
     *
     * @var OrderLineItemAdjustment
     */
    public readonly OrderLineItemAdjustment $fee;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'fee') {
            throw new \InvalidArgumentException('Invalid fee refund order line item.');
        }
        $this->fee = \Inttegro\ValueHydrator::object(
            $data['fee'] ?? null,
            [OrderLineItemAdjustment::class],
            false,
        );
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
