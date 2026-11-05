<?php

namespace Inttegro\OperatingPolicy;

/** Payout configuration selected for an application. */
final class PayoutsCapabilities extends \Inttegro\DomainValue
{
    /** Selected enabled state; PHP type: `bool|null`; wire field: `enabled` (`boolean`). */
    public readonly ?bool $enabled;
    /** Selected payout limits; PHP type: `Limits|null`; wire field: `limits` (`object`). */
    public readonly ?Limits $limits;
    /** Resolved aging configuration; PHP type: `BTAgingSpec|null`; wire field: `bt_aging_spec` (`object`). */
    public readonly ?BTAgingSpec $btAgingSpec;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->enabled = \Inttegro\ValueHydrator::bool($data['enabled'] ?? null, true);
        $this->limits = \Inttegro\ValueHydrator::object($data['limits'] ?? null, [Limits::class], true);
        $this->btAgingSpec = \Inttegro\ValueHydrator::object($data['bt_aging_spec'] ?? null, [BTAgingSpec::class], true);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
