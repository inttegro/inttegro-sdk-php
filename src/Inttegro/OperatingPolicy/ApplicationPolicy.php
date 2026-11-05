<?php

namespace Inttegro\OperatingPolicy;

/** Immutable operating-policy snapshot applied to an application. */
final class ApplicationPolicy extends \Inttegro\DomainValue
{
    /** Applied capabilities; PHP type: `Capabilities`; wire field: `capabilities` (`object`). */
    public readonly Capabilities $capabilities;
    /** Snapshot provenance; PHP type: `Source`; wire field: `source` (`object`). */
    public readonly Source $source;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->capabilities = \Inttegro\ValueHydrator::object($data['capabilities'] ?? null, [Capabilities::class], false);
        $this->source = \Inttegro\ValueHydrator::object($data['source'] ?? null, [Source::class], false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
