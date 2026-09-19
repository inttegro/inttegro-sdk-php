<?php

namespace Inttegro\Refund;

/** Immutable product order-line snapshot attached to a refund. */
final class ProductOrderLineItem extends \Inttegro\DomainValue
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
     * Discriminator identifying this snapshot as a product line.
     *
     * Required response field. PHP type: `string`; wire field: `type` (`string`, always `product`).
     *
     * @var string
     */
    public readonly string $type;

    /**
     * Quantity of the product captured on the order.
     *
     * Required response field. PHP type: `int`; wire field: `quantity` (`integer`).
     *
     * @var int
     */
    public readonly int $quantity;

    /**
     * Product identity captured on the order.
     *
     * Required response field. PHP type: `OrderLineItemProduct`; wire field: `product` (`object`).
     *
     * @var OrderLineItemProduct
     */
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
