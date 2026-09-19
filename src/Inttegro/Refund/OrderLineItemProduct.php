<?php

namespace Inttegro\Refund;

/** Product identity captured in a refund order-line snapshot. */
final class OrderLineItemProduct extends \Inttegro\DomainValue
{
    /**
     * Source catalog product identifier when the order used a saved product.
     *
     * Optional response field. PHP type: `string|null`; wire field: `id` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $id;

    /**
     * Product name captured on the order.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     *
     * @var string
     */
    public readonly string $name;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
