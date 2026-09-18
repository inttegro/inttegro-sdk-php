<?php

namespace Inttegro\Refund;

/** Descriptive fields captured for a refund fee or shipping line. */
final class OrderLineItemAdjustment extends \Inttegro\DomainValue
{
    public readonly ?string $label;
    public readonly ?string $description;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
