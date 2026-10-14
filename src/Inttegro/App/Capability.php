<?php

namespace Inttegro\App;

use DateTimeImmutable;

/** Current availability of one commerce capability. */
final class Capability extends \Inttegro\DomainValue
{
    /** Current capability state. Required response field. PHP type: `string`; wire field: `status` (`string`). */
    public readonly string $status;
    /** Last state-change time. Required response field. PHP type: `DateTimeImmutable`; wire field: `status_changed_at` (`string`). */
    public readonly DateTimeImmutable $statusChangedAt;
    /** Public reason for an unavailable capability. Optional response field. PHP type: `string|null`; wire field: `status_reason` (`string`). */
    public readonly ?string $statusReason;
    /** Outstanding setup requirements. Optional response field. PHP type: `CapabilityRequirements|null`; wire field: `requirements` (`object`). */
    public readonly ?CapabilityRequirements $requirements;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->statusChangedAt = \Inttegro\ValueHydrator::dateTime($data['status_changed_at'] ?? null, false);
        $this->statusReason = \Inttegro\ValueHydrator::string($data['status_reason'] ?? null, true);
        $this->requirements = \Inttegro\ValueHydrator::object(
            $data['requirements'] ?? null,
            [CapabilityRequirements::class],
            true,
        );
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
