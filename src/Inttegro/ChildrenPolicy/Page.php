<?php

namespace Inttegro\ChildrenPolicy;

/** One page of immutable children-policy versions, ordered newest first. */
final class Page extends \Inttegro\DomainValue
{
    /** Page number; PHP type: `int`; wire field: `number` (`integer`). */
    public readonly int $number;
    /** Requested page size; PHP type: `int`; wire field: `size` (`integer`). */
    public readonly int $size;
    /** Versions returned on this page; PHP type: `int`; wire field: `count` (`integer`). */
    public readonly int $count;
    /** Total matching versions; PHP type: `int`; wire field: `total` (`integer`). */
    public readonly int $total;
    /** Whether another page exists; PHP type: `bool`; wire field: `has_more` (`boolean`). */
    public readonly bool $hasMore;

    /**
     * Immutable policy versions; PHP type: `list<ChildrenPolicy>`; wire field: `versions`
     * (`array<object>`).
     *
     * @var list<ChildrenPolicy>
     */
    public readonly array $versions;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::int($data['number'] ?? null, false);
        $this->size = \Inttegro\ValueHydrator::int($data['size'] ?? null, false);
        $this->count = \Inttegro\ValueHydrator::int($data['count'] ?? null, false);
        $this->total = \Inttegro\ValueHydrator::int($data['total'] ?? null, false);
        $this->hasMore = \Inttegro\ValueHydrator::bool($data['has_more'] ?? null, false);
        $this->versions = \Inttegro\ValueHydrator::objects($data['versions'] ?? null, [ChildrenPolicy::class]);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
