<?php

namespace Inttegro\App;

use DateTimeImmutable;

/**
 * Identifies the created app's direct placement relationship.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Relationship extends \Inttegro\DomainValue
{
    /**
     * Unique identifier for this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Kind value for this relationship.
     *
     * Required response field. PHP type: `string`; wire field: `kind` (`string`).
     *
     * @var string
     */
    public readonly string $kind;

    /**
     * Application that directly contains this app.
     *
     * Required response field. PHP type: `\Inttegro\App\RelationshipParent`; wire field:
     * `parent` (`object`).
     *
     * @var \Inttegro\App\RelationshipParent
     */
    public readonly \Inttegro\App\RelationshipParent $parent;

    /**
     * Current lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Time at which the value was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at` (`ISO-8601
     * string with UTC offset`).
     * The SDK parses the offset-bearing timestamp into an immutable PHP date-time value.
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Hydrates a Relationship from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->kind = \Inttegro\ValueHydrator::string($data['kind'] ?? null, false);
        $this->parent = \Inttegro\ValueHydrator::object($data['parent'] ?? null, [\Inttegro\App\RelationshipParent::class], false);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
    }

    /**
     * Creates a Relationship from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Relationship value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
