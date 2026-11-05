<?php

namespace Inttegro\ChildrenPolicy;

/** Inclusive amount bounds granted by a children policy, in minor currency units. */
final class AmountRange extends \Inttegro\DomainValue
{
    /** Minimum amount; PHP type: `int`; wire field: `min` (`integer`). */
    public readonly int $min;
    /** Maximum amount; PHP type: `int`; wire field: `max` (`integer`). */
    public readonly int $max;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->min = \Inttegro\ValueHydrator::int($data['min'] ?? null, false);
        $this->max = \Inttegro\ValueHydrator::int($data['max'] ?? null, false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
