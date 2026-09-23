<?php

use PHPUnit\Framework\TestCase;

final class BalanceTransactionAllocationTest extends TestCase
{
	public function test_it_hydrates_public_allocation_summary(): void
	{
		$transaction = \Inttegro\BalanceTransaction\BalanceTransaction::fromArray([
			'id' => 'bt_1',
			'type' => 'payment',
			'payment_id' => 'py_1',
			'order_id' => 'or_1',
			'amount' => ['currency' => 'ghs', 'value' => 2500],
			'available_amount' => ['currency' => 'ghs', 'value' => 1500],
			'pending_amount' => ['currency' => 'ghs', 'value' => 1000],
			'spent_amount' => ['currency' => 'ghs', 'value' => 0],
			'allocations' => [[
				'id' => 'bta_1',
				'type' => 'payout',
				'status' => 'pending',
				'payout' => [
					'id' => 'po_1',
					'amount' => ['currency' => 'ghs', 'value' => 1000],
				],
				'created_at' => '2026-09-02T12:01:00Z',
				'updated_at' => '2026-09-02T12:01:00Z',
			]],
			'created_at' => '2026-09-02T12:00:00Z',
		]);

		$this->assertSame(1500, $transaction->availableAmount->value);
		$allocation = $transaction->allocations[0];
		$this->assertInstanceOf(\Inttegro\BalanceTransaction\PayoutAllocation::class, $allocation);
		$this->assertSame('po_1', $allocation->payout->id);
	}
}
