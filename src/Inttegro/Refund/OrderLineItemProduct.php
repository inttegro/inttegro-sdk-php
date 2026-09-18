<?php

namespace Inttegro\Refund;

/** Product identity captured in a refund order-line snapshot. */
final class OrderLineItemProduct extends \Inttegro\DomainValue
{
    public readonly ?string $id;
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
