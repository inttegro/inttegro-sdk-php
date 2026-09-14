<?php

namespace Inttegro\Payout;

/**
 * Pagination parameters for retrieving payout history.
 *
 * The API uses one-based page numbers. Page size is optional and may be at most 256.
 */
final class PageRequest extends \Inttegro\DomainValue
{
    /**
     * One-based page index, from 1 through 10.
     *
     * Required request field. PHP type: `int`; wire field: `page_number` (`integer`).
     */
    public readonly int $pageNumber;

    /**
     * Maximum number of payouts to return, from 1 through 256.
     *
     * Optional request field. PHP type: `int|null`; wire field: `page_size` (`integer`).
     */
    public readonly ?int $pageSize;

    /** @param array{page_number: int, page_size?: int|null} $data */
    public function __construct(array $data)
    {
        $this->pageNumber = \Inttegro\ValueHydrator::int($data['page_number'], false);
        $this->pageSize = \Inttegro\ValueHydrator::int($data['page_size'] ?? null, true);
    }

    /** @param array{page_number: int, page_size?: int|null} $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
