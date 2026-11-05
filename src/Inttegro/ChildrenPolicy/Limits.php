<?php

namespace Inttegro\ChildrenPolicy;

/** Amount limits granted by a children policy. */
final class Limits extends \Inttegro\DomainValue
{
    /** Amount bounds; PHP type: `AmountRange`; wire field: `amount` (`object`). */
    public readonly AmountRange $amount;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [AmountRange::class], false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
