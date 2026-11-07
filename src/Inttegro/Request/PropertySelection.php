<?php

namespace Inttegro\Request;

use Inttegro\DomainValue;
use InvalidArgumentException;

/**
 * Immutable public-property selection for one response resource.
 *
 * Construct selections with `pick()` or `omit()` so the wire object contains
 * exactly one non-empty selection mode.
 */
final class PropertySelection extends DomainValue
{
    /**
     * @param list<string>|null $pick Properties to include with required ancestors.
     * @param list<string>|null $omit Properties and descendants to exclude.
     */
    private function __construct(
        public readonly ?array $pick,
        public readonly ?array $omit,
    ) {
    }

    /** @param non-empty-list<string> $propertyPaths */
    public static function pick(array $propertyPaths): self
    {
        return new self(self::paths('pick', $propertyPaths), null);
    }

    /** @param non-empty-list<string> $propertyPaths */
    public static function omit(array $propertyPaths): self
    {
        return new self(null, self::paths('omit', $propertyPaths));
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        if (array_key_exists('pick', $data) === array_key_exists('omit', $data)) {
            throw new InvalidArgumentException('Property selection requires exactly one of pick or omit.');
        }
        return array_key_exists('pick', $data)
            ? self::pick((array) $data['pick'])
            : self::omit((array) $data['omit']);
    }

    /** @return array{pick: list<string>}|array{omit: list<string>} */
    public function toArray(): array
    {
        return $this->pick !== null ? ['pick' => $this->pick] : ['omit' => $this->omit ?? []];
    }

    /** @param list<mixed> $propertyPaths @return non-empty-list<string> */
    private static function paths(string $mode, array $propertyPaths): array
    {
        if ($propertyPaths === []) {
            throw new InvalidArgumentException("$mode must contain at least one property path.");
        }
        foreach ($propertyPaths as $path) {
            if (!is_string($path) || trim($path) === '') {
                throw new InvalidArgumentException("$mode property paths must be non-empty strings.");
            }
        }
        return $propertyPaths;
    }
}
