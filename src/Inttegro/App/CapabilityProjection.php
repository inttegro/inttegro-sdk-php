<?php

namespace Inttegro\App;

/** Capability states currently exposed on an app resource. */
final class CapabilityProjection extends \Inttegro\DomainValue
{
    /** Known payment capability state, when available. Optional response field. PHP type: `Capability|null`; wire field: `payments` (`object`). */
    public readonly ?Capability $payments;
    /** Known payout capability state, when available. Optional response field. PHP type: `Capability|null`; wire field: `payouts` (`object`). */
    public readonly ?Capability $payouts;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->payments = \Inttegro\ValueHydrator::object($data['payments'] ?? null, [Capability::class], true);
        $this->payouts = \Inttegro\ValueHydrator::object($data['payouts'] ?? null, [Capability::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
