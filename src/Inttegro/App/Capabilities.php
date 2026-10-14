<?php

namespace Inttegro\App;

/** Payment and payout capabilities available to the authenticated app. */
final class Capabilities extends \Inttegro\DomainValue
{
    /** Payment capability state. Required response field. PHP type: `Capability`; wire field: `payments` (`object`). */
    public readonly Capability $payments;
    /** Payout capability state. Required response field. PHP type: `Capability`; wire field: `payouts` (`object`). */
    public readonly Capability $payouts;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->payments = \Inttegro\ValueHydrator::object($data['payments'] ?? null, [Capability::class], false);
        $this->payouts = \Inttegro\ValueHydrator::object($data['payouts'] ?? null, [Capability::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
