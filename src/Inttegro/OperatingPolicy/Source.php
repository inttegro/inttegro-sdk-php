<?php

namespace Inttegro\OperatingPolicy;

/** Identifies whether an app's policy snapshot was inline or came from a reusable template. */
final class Source extends \Inttegro\DomainValue
{
    /** Source kind, `inline` or `template`; PHP type: `string`; wire field: `type` (`string`). */
    public readonly string $type;
    /** Template identifier; PHP type: `string|null`; wire field: `id` (`string`). */
    public readonly ?string $id;
    /** Template version; PHP type: `int|null`; wire field: `version` (`integer`). */
    public readonly ?int $version;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->version = \Inttegro\ValueHydrator::int($data['version'] ?? null, true);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
