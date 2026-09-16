<?php

use Inttegro\Order\Order;
use Inttegro\Customer\AddressInput;
use Inttegro\Customer\CreateRequest as CreateCustomerRequest;
use Inttegro\Customer\Customer;
use Inttegro\Customer\UpdateRequest as UpdateCustomerRequest;
use Inttegro\CustomData;
use Inttegro\CustomDataInput;
use Inttegro\CustomDataPatch;
use Inttegro\Payment\Payment;
use Inttegro\PaymentMethod\PaymentMethod;
use Inttegro\Payout\PageRequest;
use Inttegro\Payout\ScheduleRequest;
use Inttegro\Product\Product;
use Inttegro\PurchaseIntent\PurchaseIntent;
use Inttegro\Refund\FailureReason;
use Inttegro\Refund\PaymentMethodSettlement;
use Inttegro\Refund\Refund;
use PHPUnit\Framework\TestCase;

final class ResourceSemanticsTest extends TestCase
{
    public function testCustomerRequestsUseTypedAddressesAndCustomData(): void
    {
        $address = new AddressInput([
            'city' => 'Accra',
            'country' => 'gh',
            'line1' => '1 Independence Avenue',
        ]);
        $customData = new CustomDataInput([
            'preferences' => ['newsletter' => true],
            'segment' => 'founder',
        ]);
        $create = new CreateCustomerRequest([
            'billing_address' => $address,
            'custom_data' => $customData,
            'name' => 'Ama Mensah',
        ]);
        $update = new UpdateCustomerRequest([
            'customer_id' => 'cu_123',
            'shipping_address' => $address,
        ]);

        self::assertInstanceOf(AddressInput::class, $create->billingAddress);
        self::assertInstanceOf(CustomDataInput::class, $create->customData);
        self::assertSame('Accra', $create->toArray()['billing_address']['city']);
        self::assertTrue($create->toArray()['custom_data']['preferences']['newsletter']);
        self::assertSame('gh', $update->toArray()['shipping_address']['country']);
        self::assertArrayNotHasKey('billing_address', $update->toArray());
    }

    public function testCustomDataCollectionsAreImmutableAndPatchAware(): void
    {
        $returned = CustomData::fromArray(['segment' => 'founder']);
        $updated = $returned->with('region', 'gh');
        $patch = (new CustomDataPatch(['segment' => 'founder']))->removing('segment');

        self::assertSame(['segment' => 'founder'], $returned->toArray());
        self::assertSame('gh', $updated['region']);
        self::assertSame(['segment' => null], $patch->toArray());

        $customer = Customer::fromArray([
            'created_at' => '2026-09-16T06:00:00Z',
            'custom_data' => ['segment' => 'founder'],
            'guest' => false,
            'id' => 'cu_123',
            'name' => 'Ama Mensah',
        ]);
        self::assertInstanceOf(CustomData::class, $customer->customData);
    }

    public function testPayoutRequestsExposeKnownFieldsStatically(): void
    {
        $page = new PageRequest(['page_number' => 2, 'page_size' => 100]);
        $schedule = new ScheduleRequest([
            'destination_id' => 'fa_ghs',
            'execute_after' => '2026-09-15T09:00:00Z',
            'max_amount' => 12500,
            'reference' => 'PAYOUT-1',
        ]);

        self::assertSame(2, $page->pageNumber);
        self::assertSame('fa_ghs', $schedule->destinationId);
        self::assertSame('2026-09-15T09:00:00.000+00:00', $schedule->toArray()['execute_after']);
    }

    public function testRefundFailureIsStronglyTypedAndSanitized(): void
    {
        $refund = Refund::fromArray([
            'created_at' => '2026-09-14T12:00:00Z',
            'failure' => [
                'detail' => 'The refund could not be completed.',
                'reason' => 'unknown',
                'retryable' => false,
            ],
            'id' => 'rf_123',
            'line_items' => [],
            'order_id' => 'or_123',
            'reason' => 'item_returned',
            'settlement' => [
                'type' => 'payment_method',
                'payment_method' => [
                    'id' => 'pm_123',
                    'type' => 'mobile_money',
                    'mobile_money' => [
                        'network' => 'mtn',
                        'account_number' => '****7831',
                        'last4' => '7831',
                    ],
                ],
            ],
            'status' => 'failed',
            'total' => ['currency' => 'ghs', 'value' => 100],
        ]);

        self::assertSame(FailureReason::Unknown, $refund->failure?->reason);
        self::assertInstanceOf(PaymentMethodSettlement::class, $refund->settlement);
        self::assertSame('****7831', $refund->settlement->paymentMethod->mobileMoney->accountNumber);
        self::assertFalse($refund->failure?->retryable);
        self::assertSame('unknown', $refund->toArray()['failure']['reason']);
    }

    public function testPaymentAndOrderQuestions(): void
    {
        $payment = Payment::fromArray([
            'amount' => ['currency' => 'ghs', 'value' => 1000],
            'id' => 'py_123',
            'initiated_at' => '2026-09-09T12:00:00Z',
            'next_action' => ['type' => 'redirect'],
            'statement_descriptor' => 'INTTEGRO',
            'status' => 'requires_action',
        ]);
        $order = Order::fromArray([
            'customer' => ['guest' => false, 'id' => 'cu_123', 'name' => 'Ama'],
            'id' => 'or_123',
            'initiated_at' => '2026-09-09T12:00:00Z',
            'payment' => $payment->toArray(),
            'status' => 'requires_payment',
        ]);

        self::assertTrue($payment->requiresAction());
        self::assertFalse($payment->isTerminal());
        self::assertSame('redirect', $payment->requiredAction()?->type);
        self::assertTrue($order->requiresPayment());
        self::assertSame('redirect', $order->requiredPaymentAction()?->type);
    }

    public function testCatalogAndPaymentMethodQuestions(): void
    {
        $intent = PurchaseIntent::fromArray([
            'allow_variants' => false,
            'created_at' => '2026-09-09T12:00:00Z',
            'id' => 'sale_123',
            'quantity' => ['min' => 1],
            'status' => 'used',
            'usage' => [
                'order' => ['created_at' => '2026-09-09T12:01:00Z', 'id' => 'or_123'],
                'single_use' => true,
            ],
        ]);
        $product = Product::fromArray([
            'active' => true,
            'created_at' => '2026-09-09T12:00:00Z',
            'id' => 'prod_123',
            'name' => 'Tea guide',
            'published_at' => '2026-09-09T12:00:00Z',
            'type' => 'digital',
        ]);
        $method = PaymentMethod::fromArray([
            'active' => true,
            'created_at' => '2026-09-09T12:00:00Z',
            'customer_id' => 'cu_123',
            'id' => 'pm_123',
            'type' => 'mobile_money',
            'verified_at' => '2026-09-09T12:00:00Z',
        ]);

        self::assertTrue($intent->isSingleUse());
        self::assertSame('or_123', $intent->usedOrderId());
        self::assertTrue($product->isPublished());
        self::assertTrue($product->wasEverPublished());
        self::assertTrue($method->isVerified());
        self::assertTrue($method->isReusable());
    }
}
