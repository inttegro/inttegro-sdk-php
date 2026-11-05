<?php

namespace Inttegro\ChildrenPolicy;

use DateTimeImmutable;

/** Latest active version of the authority assigned to an app for configuring children. */
final class ChildrenPolicy extends \Inttegro\DomainValue
{
    /** Policy identifier; PHP type: `string`; wire field: `id` (`string`). */
    public readonly string $id;
    /** Owning application; PHP type: `string`; wire field: `owner_application_id` (`string`). */
    public readonly string $ownerApplicationId;
    /** Returned version; PHP type: `int`; wire field: `version` (`integer`). */
    public readonly int $version;
    /** Active version; PHP type: `int`; wire field: `active_version` (`integer`). */
    public readonly int $activeVersion;
    /** Policy name; PHP type: `string`; wire field: `name` (`string`). */
    public readonly string $name;
    /** Policy description; PHP type: `string|null`; wire field: `description` (`string`). */
    public readonly ?string $description;
    /** Granted authority; PHP type: `Capabilities`; wire field: `capabilities` (`object`). */
    public readonly Capabilities $capabilities;
    /** Initial creation time; PHP type: `DateTimeImmutable`; wire field: `created_at` (`date-time`). */
    public readonly DateTimeImmutable $createdAt;
    /** Latest update time; PHP type: `DateTimeImmutable`; wire field: `updated_at` (`date-time`). */
    public readonly DateTimeImmutable $updatedAt;
    /** Version creation time; PHP type: `DateTimeImmutable`; wire field: `version_created_at` (`date-time`). */
    public readonly DateTimeImmutable $versionCreatedAt;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->ownerApplicationId = \Inttegro\ValueHydrator::string($data['owner_application_id'] ?? null, false);
        $this->version = \Inttegro\ValueHydrator::int($data['version'] ?? null, false);
        $this->activeVersion = \Inttegro\ValueHydrator::int($data['active_version'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->description = \Inttegro\ValueHydrator::string($data['description'] ?? null, true);
        $this->capabilities = \Inttegro\ValueHydrator::object($data['capabilities'] ?? null, [Capabilities::class], false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, false);
        $this->versionCreatedAt = \Inttegro\ValueHydrator::dateTime($data['version_created_at'] ?? null, false);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
