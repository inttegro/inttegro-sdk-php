<?php

namespace Inttegro\Refund;

/** Immutable product order-line snapshot attached to a refund. */
final class ProductOrderLineItem extends \Inttegro\DomainValue
{
    public readonly string $id;
    public readonly string $type;
    public readonly int $quantity;
    public readonly OrderLineItemProduct $product;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'product') {
            throw new \InvalidArgumentException('Invalid product refund order line item.');
        }
        $this->quantity = \Inttegro\ValueHydrator::int($data['quantity'] ?? null, false);
        $this->product = \Inttegro\ValueHydrator::object(
            $data['product'] ?? null,
            [OrderLineItemProduct::class],
            false,
        );
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
