<?php

namespace Inttegro\Refund;

/** Descriptive fields captured for a refund fee or shipping line. */
final class OrderLineItemAdjustment extends \Inttegro\DomainValue
{
    /**
     * Human-readable label captured on the order line.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /**
     * Human-readable description captured on the order line.
     *
     * Optional response field. PHP type: `string|null`; wire field: `description` (`string`).
     *
     * @var string|null
     */
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
