<?php

namespace Inttegro\App;

/** Public identity of the application that directly contains another application. */
final class RelationshipParent extends \Inttegro\DomainValue
{
    /**
     * Parent application identifier.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     */
    public readonly string $id;

    /**
     * Current parent application name.
     *
     * Required response field. PHP type: `string`; wire field: `name` (`string`).
     */
    public readonly string $name;

    /**
     * Current parent application alias.
     *
     * Optional response field. PHP type: `string|null`; wire field: `alias` (`string`).
     */
    public readonly ?string $alias;

    /**
     * Hydrates a parent application summary from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, false);
        $this->alias = \Inttegro\ValueHydrator::string($data['alias'] ?? null, true);
    }

    /**
     * Creates a parent application summary from its decoded API representation.
     *
     * @param array<string, mixed> $data Wire object keyed by API field names.
     * @return static A typed, immutable parent application summary.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
