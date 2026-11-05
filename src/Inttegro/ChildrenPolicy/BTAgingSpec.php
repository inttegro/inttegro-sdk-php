<?php

namespace Inttegro\ChildrenPolicy;

/** Platform-owned balance-transaction aging option granted by a children policy. */
final class BTAgingSpec extends \Inttegro\DomainValue
{
    /** Public aging-spec identifier; PHP type: `string`; wire field: `public_id` (`string`). */
    public readonly string $publicId;
    /** Whole-hour aging duration; PHP type: `string`; wire field: `t_plus` (`string`). */
    public readonly string $tPlus;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->publicId = \Inttegro\ValueHydrator::string($data['public_id'] ?? null, false);
        $this->tPlus = \Inttegro\ValueHydrator::string($data['t_plus'] ?? null, false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
