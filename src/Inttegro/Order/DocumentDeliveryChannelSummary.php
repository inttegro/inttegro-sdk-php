<?php

namespace Inttegro\Order;

use DateTimeImmutable;

/** Accepted deliveries aggregated for one channel. */
final class DocumentDeliveryChannelSummary extends \Inttegro\DomainValue
{
    /** Accepted deliveries through this channel. Required response field. PHP type: `int`; wire field: `count` (`integer`). */
    public readonly int $count;
    /** Most recent accepted delivery time. Required response field. PHP type: `DateTimeImmutable`; wire field: `latest_sent_at` (`string`). */
    public readonly DateTimeImmutable $latestSentAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->count = \Inttegro\ValueHydrator::int($data['count'] ?? null, false);
        $this->latestSentAt = \Inttegro\ValueHydrator::dateTime($data['latest_sent_at'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
