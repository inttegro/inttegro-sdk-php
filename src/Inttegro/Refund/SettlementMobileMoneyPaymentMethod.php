<?php

namespace Inttegro\Refund;

/** Caller-safe mobile-money snapshot used as a refund destination. */
final class SettlementMobileMoneyPaymentMethod extends \Inttegro\DomainValue
{
    /** Public identifier of the original payment method. Wire field: `id`. */
    public readonly string $id;

    /** Required mobile-money discriminator. Wire field: `type`. */
    public readonly string $type;

    /** Masked mobile-money recognition details. Wire field: `mobile_money`. */
    public readonly SettlementMobileMoney $mobileMoney;

    /**
     * Hydrates a mobile-money settlement snapshot from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'mobile_money') {
            throw new \InvalidArgumentException('Invalid mobile-money refund settlement.');
        }
        $this->mobileMoney = \Inttegro\ValueHydrator::object(
            $data['mobile_money'] ?? null,
            [SettlementMobileMoney::class],
            false,
        );
    }

    /**
     * Creates a mobile-money settlement snapshot from its API representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
