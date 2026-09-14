<?php

namespace Inttegro\Payout;

use DateTimeImmutable;

/**
 * Parameters for scheduling a payout to a financial account.
 *
 * Amounts use the smallest currency unit. When `execute_after` is omitted, Inttegro may begin
 * execution as soon as the payout is eligible.
 */
final class ScheduleRequest extends \Inttegro\DomainValue
{
    /**
     * Financial account that should receive the payout.
     *
     * Required request field. PHP type: `string`; wire field: `destination_id` (`string`).
     */
    public readonly string $destinationId;

    /**
     * Optional future time after which execution may begin.
     *
     * Optional request field. PHP type: `DateTimeImmutable|null`; wire field: `execute_after`
     * (`ISO-8601 date-time string`).
     */
    public readonly ?DateTimeImmutable $executeAfter;

    /**
     * Optional maximum transfer amount in the smallest currency unit.
     *
     * Optional request field. PHP type: `int|null`; wire field: `max_amount` (`integer`).
     */
    public readonly ?int $maxAmount;

    /**
     * Merchant reference carried on the payout.
     *
     * Required request field. PHP type: `string`; wire field: `reference` (`string`).
     */
    public readonly string $reference;

    /**
     * @param array{
     *   destination_id: string,
     *   execute_after?: DateTimeImmutable|string|null,
     *   max_amount?: int|null,
     *   reference: string
     * } $data
     */
    public function __construct(array $data)
    {
        $this->destinationId = \Inttegro\ValueHydrator::string($data['destination_id'] ?? null, false);
        $this->executeAfter = \Inttegro\ValueHydrator::dateTime($data['execute_after'] ?? null, true);
        $this->maxAmount = \Inttegro\ValueHydrator::int($data['max_amount'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
