<?php

namespace Inttegro\Refund;

/** Refund settlement returned to the original payment method. */
final class PaymentMethodSettlement extends \Inttegro\DomainValue
{
    /** Required discriminator for original-method settlement. Wire field: `type`. */
    public readonly string $type;

    /** Caller-safe snapshot of the original payment method. Wire field: `payment_method`. */
    public readonly SettlementMobileMoneyPaymentMethod|SettlementBankAccountPaymentMethod $paymentMethod;

    /**
     * Hydrates a payment-method settlement from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'payment_method') {
            throw new \InvalidArgumentException('Invalid payment-method refund settlement.');
        }
        $method = \Inttegro\ValueHydrator::array($data['payment_method'] ?? null, false);
        $methodType = \Inttegro\ValueHydrator::string($method['type'] ?? null, false);
        $this->paymentMethod = match ($methodType) {
            'mobile_money' => SettlementMobileMoneyPaymentMethod::fromArray($method),
            'bank_account' => SettlementBankAccountPaymentMethod::fromArray($method),
            default => throw new \InvalidArgumentException('Unsupported refund payment-method settlement type.'),
        };
    }

    /**
     * Creates a payment-method settlement from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
