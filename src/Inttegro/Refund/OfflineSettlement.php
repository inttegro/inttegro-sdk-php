<?php

namespace Inttegro\Refund;

/** Refund settlement for an order paid outside Inttegro. */
final class OfflineSettlement extends \Inttegro\DomainValue
{
    /** Required discriminator for an offline settlement. Wire field: `type`. */
    public readonly string $type;

    /**
     * Hydrates an offline settlement from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'offline' || array_key_exists('payment_method', $data)) {
            throw new \InvalidArgumentException('Invalid offline refund settlement.');
        }
    }

    /**
     * Creates an offline settlement from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
