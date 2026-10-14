<?php

namespace Inttegro\App;

use DateTimeImmutable;

/** A setup item that must be completed before a capability can be enabled. */
final class CapabilityRequirement extends \Inttegro\DomainValue
{
    /** Stable requirement identifier. Required response field. PHP type: `string`; wire field: `code` (`string`). */
    public readonly string $code;
    /** Public completion guidance. Required response field. PHP type: `string`; wire field: `description` (`string`). */
    public readonly string $description;
    /** Completion deadline, when one applies. Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `due_at` (`string|null`). */
    public readonly ?DateTimeImmutable $dueAt;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->code = \Inttegro\ValueHydrator::string($data['code'] ?? null, false);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, false);
        $this->dueAt = \Inttegro\ValueHydrator::dateTime($data['due_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
