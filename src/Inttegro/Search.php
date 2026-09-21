<?php

namespace Inttegro;

enum ResourceSearchOperator: string { case Equal = 'eq'; case In = 'in'; }
enum ResourceSearchSortField: string { case Relevance = 'relevance'; case UpdatedAt = 'updated_at'; case PublishedAt = 'published_at'; }
enum ResourceSearchSortDirection: string { case Ascending = 'asc'; case Descending = 'desc'; }
enum ResourceSearchResourceType: string { case Customer = 'customer'; case FinancialAccount = 'financial_account'; case Order = 'order'; case Payout = 'payout'; case Product = 'product'; }
enum ResourceSearchTotalRelation: string { case Exact = 'exact'; case LowerBound = 'lower_bound'; }
enum ResourceSearchFreshnessState: string { case Current = 'current'; case Delayed = 'delayed'; case Partial = 'partial'; case Unknown = 'unknown'; case Unavailable = 'unavailable'; }

final class ResourceSearchFilter extends DomainValue
{
    /** @param list<string> $values */
    public function __construct(public readonly string $field, public readonly ResourceSearchOperator $operator, public readonly array $values) {}
    public static function fromArray(array $data): static { return new static((string) $data['field'], ResourceSearchOperator::from((string) $data['operator']), array_values($data['values'])); }
}

final class ResourceSearchFacet extends DomainValue
{
    public function __construct(public readonly string $field, public readonly ?int $limit = null) {}
    public static function fromArray(array $data): static { return new static((string) $data['field'], isset($data['limit']) ? (int) $data['limit'] : null); }
}

final class ResourceSearchSort extends DomainValue
{
    public function __construct(public readonly ResourceSearchSortField $field, public readonly ResourceSearchSortDirection $direction) {}
    public static function fromArray(array $data): static { return new static(ResourceSearchSortField::from((string) $data['field']), ResourceSearchSortDirection::from((string) $data['direction'])); }
}

final class ResourceSearchRequest extends DomainValue
{
    /** @param list<ResourceSearchFilter>|null $filters @param list<ResourceSearchFacet>|null $facets */
    public function __construct(
        public readonly ?string $text = null,
        public readonly ?array $filters = null,
        public readonly ?array $facets = null,
        public readonly ?ResourceSearchSort $sort = null,
        public readonly ?int $pageSize = null,
        public readonly ?string $cursor = null,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            isset($data['text']) ? (string) $data['text'] : null,
            isset($data['filters']) ? array_map(static fn(array $item) => ResourceSearchFilter::fromArray($item), $data['filters']) : null,
            isset($data['facets']) ? array_map(static fn(array $item) => ResourceSearchFacet::fromArray($item), $data['facets']) : null,
            isset($data['sort']) ? ResourceSearchSort::fromArray($data['sort']) : null,
            isset($data['page_size']) ? (int) $data['page_size'] : null,
            isset($data['cursor']) ? (string) $data['cursor'] : null,
        );
    }
}

final class ResourceSearchTotal extends DomainValue
{
    public function __construct(public readonly int $value, public readonly ResourceSearchTotalRelation $relation) {}
    public static function fromArray(array $data): static { return new static((int) $data['value'], ResourceSearchTotalRelation::from((string) $data['relation'])); }
}

final class ResourceSearchResourceTotal extends DomainValue
{
    public function __construct(public readonly ResourceSearchResourceType $resourceType, public readonly int $value, public readonly ResourceSearchTotalRelation $relation) {}
    public static function fromArray(array $data): static { return new static(ResourceSearchResourceType::from((string) $data['resource_type']), (int) $data['value'], ResourceSearchTotalRelation::from((string) $data['relation'])); }
}

final class ResourceSearchResourceReference extends DomainValue
{
    public function __construct(public readonly ResourceSearchResourceType $type, public readonly string $id) {}
    public static function fromArray(array $data): static { return new static(ResourceSearchResourceType::from((string) $data['type']), (string) $data['id']); }
}

final class ResourceSearchResult extends DomainValue
{
    public function __construct(
        public readonly ResourceSearchResourceReference $resource,
        public readonly string $title,
        public readonly \DateTimeImmutable $updatedAt,
        public readonly ?string $summary = null,
        public readonly ?string $status = null,
        public readonly ?string $customerName = null,
        public readonly ?\Inttegro\Money\Amount $amount = null,
        public readonly ?string $url = null,
    ) {}
    public static function fromArray(array $data): static
    {
        return new static(
            ResourceSearchResourceReference::fromArray($data['resource']),
            (string) $data['title'],
            ValueHydrator::dateTime($data['updated_at'], false),
            isset($data['summary']) ? (string) $data['summary'] : null,
            isset($data['status']) ? (string) $data['status'] : null,
            isset($data['customer_name']) ? (string) $data['customer_name'] : null,
            isset($data['amount']) ? \Inttegro\Money\Amount::fromArray($data['amount']) : null,
            isset($data['url']) ? (string) $data['url'] : null,
        );
    }
}

final class ResourceSearchFacetBucket extends DomainValue
{
    public function __construct(public readonly string $value, public readonly int $count) {}
    public static function fromArray(array $data): static { return new static((string) $data['value'], (int) $data['count']); }
}

final class ResourceSearchFacetResult extends DomainValue
{
    /** @param list<ResourceSearchFacetBucket> $buckets */
    public function __construct(public readonly string $field, public readonly array $buckets) {}
    public static function fromArray(array $data): static { return new static((string) $data['field'], array_map(static fn(array $item) => ResourceSearchFacetBucket::fromArray($item), $data['buckets'])); }
}

final class ResourceSearchResourceFreshness extends DomainValue
{
    public function __construct(
        public readonly ResourceSearchResourceType $resourceType,
        public readonly ResourceSearchFreshnessState $state,
        public readonly ?\DateTimeImmutable $observedAt = null,
        public readonly ?\DateTimeImmutable $lastIndexedAt = null,
    ) {}
    public static function fromArray(array $data): static
    {
        return new static(
            ResourceSearchResourceType::from((string) $data['resource_type']),
            ResourceSearchFreshnessState::from((string) $data['state']),
            ValueHydrator::dateTime($data['observed_at'] ?? null, true),
            ValueHydrator::dateTime($data['last_indexed_at'] ?? null, true),
        );
    }
}

final class ResourceSearchFreshness extends DomainValue
{
    /** @param list<ResourceSearchResourceFreshness>|null $resources */
    public function __construct(public readonly ResourceSearchFreshnessState $state, public readonly ?\DateTimeImmutable $observedAt = null, public readonly ?array $resources = null) {}
    public static function fromArray(array $data): static
    {
        return new static(
            ResourceSearchFreshnessState::from((string) $data['state']),
            ValueHydrator::dateTime($data['observed_at'] ?? null, true),
            isset($data['resources']) ? array_map(static fn(array $item) => ResourceSearchResourceFreshness::fromArray($item), $data['resources']) : null,
        );
    }
}

final class ResourceSearchPage extends DomainValue
{
    /**
     * @param list<ResourceSearchResourceType> $resourceTypes
     * @param list<ResourceSearchResourceTotal> $resourceTotals
     * @param list<ResourceSearchResult> $results
     * @param list<ResourceSearchFacetResult> $facets
     */
    public function __construct(
        public readonly array $resourceTypes,
        public readonly ResourceSearchSort $sort,
        public readonly int $pageSize,
        public readonly int $resultCount,
        public readonly bool $hasMore,
        public readonly ResourceSearchTotal $total,
        public readonly array $resourceTotals,
        public readonly array $results,
        public readonly array $facets,
        public readonly ResourceSearchFreshness $freshness,
        public readonly ?string $nextCursor = null,
    ) {}
    public static function fromArray(array $data): static
    {
        return new static(
            array_map(static fn(string $item) => ResourceSearchResourceType::from($item), $data['resource_types']),
            ResourceSearchSort::fromArray($data['sort']),
            (int) $data['page_size'],
            (int) $data['result_count'],
            (bool) $data['has_more'],
            ResourceSearchTotal::fromArray($data['total']),
            array_map(static fn(array $item) => ResourceSearchResourceTotal::fromArray($item), $data['resource_totals']),
            array_map(static fn(array $item) => ResourceSearchResult::fromArray($item), $data['results']),
            array_map(static fn(array $item) => ResourceSearchFacetResult::fromArray($item), $data['facets']),
            ResourceSearchFreshness::fromArray($data['freshness']),
            isset($data['next_cursor']) ? (string) $data['next_cursor'] : null,
        );
    }
}
