<?php

namespace Inttegro\Order;

/** Accepted delivery totals grouped by channel. */
final class DocumentDeliverySummaryChannels extends \Inttegro\DomainValue
{
    /** Email delivery total, when email was used. Optional response field. PHP type: `DocumentDeliveryChannelSummary|null`; wire field: `email` (`object`). */
    public readonly ?DocumentDeliveryChannelSummary $email;
    /** SMS delivery total, when SMS was used. Optional response field. PHP type: `DocumentDeliveryChannelSummary|null`; wire field: `sms` (`object`). */
    public readonly ?DocumentDeliveryChannelSummary $sms;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [DocumentDeliveryChannelSummary::class], true);
        $this->sms = \Inttegro\ValueHydrator::object($data['sms'] ?? null, [DocumentDeliveryChannelSummary::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
