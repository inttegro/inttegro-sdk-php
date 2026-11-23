<?php

namespace Inttegro\Order;

use DateTimeImmutable;

/** Accepted invoice or receipt deliveries aggregated across channels. */
final class DocumentDeliverySummary extends \Inttegro\DomainValue
{
    /** Accepted delivery totals grouped by channel. Required response field. PHP type: `DocumentDeliverySummaryChannels`; wire field: `channels` (`object`). */
    public readonly DocumentDeliverySummaryChannels $channels;
    /** Most recent accepted delivery time. Required response field. PHP type: `DateTimeImmutable`; wire field: `latest_sent_at` (`string`). */
    public readonly DateTimeImmutable $latestSentAt;
    /** Accepted deliveries across all channels. Required response field. PHP type: `int`; wire field: `total_count` (`integer`). */
    public readonly int $totalCount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->channels = \Inttegro\ValueHydrator::object($data['channels'] ?? null, [DocumentDeliverySummaryChannels::class], false);
        $this->latestSentAt = \Inttegro\ValueHydrator::dateTime($data['latest_sent_at'] ?? null, false);
        $this->totalCount = \Inttegro\ValueHydrator::int($data['total_count'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
