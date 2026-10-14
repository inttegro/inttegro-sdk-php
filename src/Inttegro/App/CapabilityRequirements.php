<?php

namespace Inttegro\App;

/** Requirements that currently prevent a capability from being enabled. */
final class CapabilityRequirements extends \Inttegro\DomainValue
{
    /**
     * Setup items that currently require attention.
     *
     * Required response field. PHP type: `list<CapabilityRequirement>`; wire field: `currently_due` (`array`).
     *
     * @var list<CapabilityRequirement>
     */
    public readonly array $currentlyDue;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->currentlyDue = \Inttegro\ValueHydrator::objects(
            $data['currently_due'] ?? null,
            [CapabilityRequirement::class],
        );
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
