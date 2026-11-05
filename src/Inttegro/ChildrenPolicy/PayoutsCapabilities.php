<?php

namespace Inttegro\ChildrenPolicy;

/** Payout choices, amount bounds, and aging options available to child applications. */
final class PayoutsCapabilities extends \Inttegro\DomainValue
{
    /** Allowed enabled states; PHP type: `list<bool>|null`; wire field: `enabled` (`array`). @var list<bool>|null */
    public readonly ?array $enabled;
    /** Allowed payout limits; PHP type: `Limits|null`; wire field: `limits` (`object`). */
    public readonly ?Limits $limits;
    /** Allowed aging options; PHP type: `list<BTAgingSpec>|null`; wire field: `bt_aging_spec` (`array`). @var list<BTAgingSpec>|null */
    public readonly ?array $btAgingSpec;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->enabled = \Inttegro\ValueHydrator::array($data['enabled'] ?? null, true);
        $this->limits = \Inttegro\ValueHydrator::object($data['limits'] ?? null, [Limits::class], true);
        $this->btAgingSpec = array_key_exists('bt_aging_spec', $data)
            ? \Inttegro\ValueHydrator::objects($data['bt_aging_spec'], [BTAgingSpec::class])
            : null;
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
