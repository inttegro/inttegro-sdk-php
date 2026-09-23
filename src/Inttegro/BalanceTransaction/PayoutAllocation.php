<?php

namespace Inttegro\BalanceTransaction;

use DateTimeImmutable;

/** Caller-safe allocation of part of a payment balance transaction to a payout. */
final class PayoutAllocation extends \Inttegro\DomainValue
{
	/** Stable allocation identifier. PHP type: `string`; wire field: `id` (`string`). */
	public readonly string $id;
	/** Discriminant fixed to payout. PHP type: `string`; wire field: `type` (`string`). */
	public readonly string $type;
	/** Caller-visible state. PHP type: `string`; wire field: `status` (`string`). */
	public readonly string $status;
	/** Payout details and amount. PHP type: `AllocationUse`; wire field: `payout` (`object`). */
	public readonly AllocationUse $payout;
	/** Reservation creation time. PHP type: `DateTimeImmutable`; wire field: `created_at` (`date-time`). */
	public readonly DateTimeImmutable $createdAt;
	/** Last public state change time. PHP type: `DateTimeImmutable`; wire field: `updated_at` (`date-time`). */
	public readonly DateTimeImmutable $updatedAt;
	/** Completion time when completed. PHP type: `DateTimeImmutable|null`; wire field: `completed_at` (`date-time`). */
	public readonly ?DateTimeImmutable $completedAt;

	/** Hydrates a payout allocation from API data. @param array<string, mixed> $data */
	public function __construct(array $data)
	{
		$this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
		$this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
		$this->status = \Inttegro\ValueHydrator::string($data['status'] ?? null, false);
		$this->payout = \Inttegro\ValueHydrator::object($data['payout'] ?? null, [AllocationUse::class], false);
		$this->createdAt = \Inttegro\ValueHydrator::dateTime($data['created_at'] ?? null, false);
		$this->updatedAt = \Inttegro\ValueHydrator::dateTime($data['updated_at'] ?? null, false);
		$this->completedAt = \Inttegro\ValueHydrator::dateTime($data['completed_at'] ?? null, true);
	}

	/** Creates a payout allocation from API data. @param array<string, mixed> $data */
	public static function fromArray(array $data): static
	{
		return new static($data);
	}
}
