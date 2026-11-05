<?php

namespace Inttegro\OperatingPolicy;

/** Selected configuration for one payment method. */
final class PaymentMethodCapabilities extends \Inttegro\DomainValue
{
    /** Selected enabled state; PHP type: `bool`; wire field: `enabled` (`boolean`). */
    public readonly bool $enabled;
    /** Whether the app confirms each use; PHP type: `bool`; wire field: `confirms_use` (`boolean`). */
    public readonly bool $confirmsUse;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->enabled = \Inttegro\ValueHydrator::bool($data['enabled'] ?? null, false);
        $this->confirmsUse = \Inttegro\ValueHydrator::bool($data['confirms_use'] ?? null, false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
