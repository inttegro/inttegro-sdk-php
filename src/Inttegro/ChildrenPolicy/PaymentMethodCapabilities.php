<?php

namespace Inttegro\ChildrenPolicy;

/** Allowed state combinations for one child payment method. */
final class PaymentMethodCapabilities extends \Inttegro\DomainValue
{
    /** Allowed enabled states; PHP type: `list<bool>`; wire field: `enabled` (`array`). @var list<bool> */
    public readonly array $enabled;
    /** Allowed confirmation states; PHP type: `list<bool>`; wire field: `confirms_use` (`array`). @var list<bool> */
    public readonly array $confirmsUse;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->enabled = \Inttegro\ValueHydrator::array($data['enabled'] ?? null, false);
        $this->confirmsUse = \Inttegro\ValueHydrator::array($data['confirms_use'] ?? null, false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
