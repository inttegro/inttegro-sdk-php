<?php

use Inttegro\Chime\Transmission;
use PHPUnit\Framework\TestCase;

final class ChimeTransmissionPrivacyTest extends TestCase
{
	public function test_it_discards_provider_and_internal_delivery_fields(): void
	{
		$transmission = Transmission::fromArray([
			'address' => 'customer@example.com',
			'created_at' => '2026-11-22T12:00:00Z',
			'initialized_at' => '2026-11-22T12:00:01Z',
			'mechanism' => 'email',
			'sent_via' => 'email',
			'status' => 'delivered',
			'provider_message_id' => 'provider-secret',
			'bounce_type' => 'Permanent',
			'bounce_sub_type' => 'Suppressed',
			'gateway' => 'private-provider',
		]);

		$public = $transmission->toArray();

		$this->assertSame('customer@example.com', $public['address']);
		$this->assertArrayNotHasKey('provider_message_id', $public);
		$this->assertArrayNotHasKey('bounce_type', $public);
		$this->assertArrayNotHasKey('bounce_sub_type', $public);
		$this->assertArrayNotHasKey('gateway', $public);
	}
}
