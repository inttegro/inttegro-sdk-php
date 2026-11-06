<?php

namespace Inttegro\OperatingPolicy;

/** Platform-resolved balance-transaction aging configuration. */
final class BTAgingSpec extends \Inttegro\DomainValue
{
    /** Aging-spec identifier; PHP type: `string`; wire field: `id` (`string`). */
    public readonly string $id;
    /** Whole-hour aging duration; PHP type: `string`; wire field: `t_plus` (`string`). */
    public readonly string $tPlus;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->tPlus = \Inttegro\ValueHydrator::string($data['t_plus'] ?? null, false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
