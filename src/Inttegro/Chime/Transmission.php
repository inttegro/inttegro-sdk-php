<?php

namespace Inttegro\Chime;

use DateTimeImmutable;

/**
 * Public delivery lifecycle for a Chime.
 *
 * Use the lifecycle status and timestamps to determine whether delivery was initialized, sent,
 * delivered, failed, or suppressed.
 *
 * @see \Inttegro\DomainValue
 */
final class Transmission extends \Inttegro\DomainValue
{
    /**
     * Recipient address used for this delivery.
     *
     * Required response field. PHP type: `string`; wire field: `address` (`string`).
     *
     * @var string
     */
    public readonly string $address;

    /**
     * Time at which the public delivery record was created.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `created_at`
     * (`ISO-8601 string with UTC offset`).
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $createdAt;

    /**
     * Time at which delivery completed, when delivered.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `delivered_at`
     * (`ISO-8601 string with UTC offset`).
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $deliveredAt;

    /**
     * Time at which delivery failed, when failed.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `failed_at`
     * (`ISO-8601 string with UTC offset`).
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $failedAt;

    /**
     * Time at which delivery processing began.
     *
     * Required response field. PHP type: `DateTimeImmutable`; wire field: `initialized_at`
     * (`ISO-8601 string with UTC offset`).
     *
     * @var DateTimeImmutable
     */
    public readonly DateTimeImmutable $initializedAt;

    /**
     * Delivery channel, such as `sms` or `email`.
     *
     * Required response field. PHP type: `string`; wire field: `mechanism` (`string`).
     *
     * @var string
     */
    public readonly string $mechanism;

    /**
     * Time at which the message was sent, when sent.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `sent_at`
     * (`ISO-8601 string with UTC offset`).
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $sentAt;

    /**
     * Channel used to send the message, when reported.
     *
     * Optional response field. PHP type: `string|null`; wire field: `sent_via` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $sentVia;

    /**
     * Current public delivery lifecycle state.
     *
     * Required response field. PHP type: `string`; wire field: `status` (`string`).
     *
     * @var string
     */
    public readonly string $status;

    /**
     * Time at which delivery to the recipient was suppressed, when applicable.
     *
     * Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `suppressed_at`
     * (`ISO-8601 string with UTC offset`).
     *
     * @var DateTimeImmutable|null
     */
    public readonly ?DateTimeImmutable $suppressedAt;

    /**
     * Hydrates a Transmission from decoded Inttegro API data.
     *
     * Unknown wire fields are ignored and are never exposed through this public value.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->address = \Inttegro\ValueHydrator::string($data['address'] ?? null, false);
        $this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
        $this->deliveredAt = \Inttegro\ValueHydrator::dateTime($data['delivered_at'] ?? null, true);
        $this->failedAt = \Inttegro\ValueHydrator::dateTime($data['failed_at'] ?? null, true);
        $this->initializedAt = \Inttegro\ValueHydrator::dateTime($data['initialized_at'] ?? null, false);
        $this->mechanism = \Inttegro\ValueHydrator::string($data['mechanism'] ?? null, false);
        $this->sentAt = \Inttegro\ValueHydrator::dateTime($data['sent_at'] ?? null, true);
        $this->sentVia = \Inttegro\ValueHydrator::string($data['sent_via'] ?? null, true);
        $this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
        $this->suppressedAt = \Inttegro\ValueHydrator::dateTime($data['suppressed_at'] ?? null, true);
    }

    /**
     * Creates a Transmission from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Transmission value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
