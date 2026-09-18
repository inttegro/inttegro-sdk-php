<?php

namespace Inttegro\Refund;

/** Immutable shipping order-line snapshot attached to a refund. */
final class ShippingOrderLineItem extends \Inttegro\DomainValue
{
    public readonly string $id;
    public readonly string $type;
    public readonly OrderLineItemAdjustment $shipping;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'shipping') {
            throw new \InvalidArgumentException('Invalid shipping refund order line item.');
        }
        $this->shipping = \Inttegro\ValueHydrator::object(
            $data['shipping'] ?? null,
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
