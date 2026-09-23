<?php

namespace Inttegro\BalanceTransaction;

/** Refund or payout reference and amount consumed from one balance transaction. */
final class AllocationUse extends \Inttegro\DomainValue
{
	/** Public consumer identifier. PHP type: `string`; wire field: `id` (`string`). */
	public readonly string $id;

	/** Amount consumed from this transaction. PHP type: `Amount`; wire field: `amount` (`object`). */
	public readonly Amount $amount;

	/** Hydrates an allocation target from API data. @param array<string, mixed> $data */
	public function __construct(array $data)
	{
		$this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
		$this->amount = \Inttegro\ValueHydrator::object($data['amount'] ?? null, [Amount::class], false);
	}

	/** Creates an allocation target from API data. @param array<string, mixed> $data */
	public static function fromArray(array $data): static
	{
		return new static($data);
	}
}
