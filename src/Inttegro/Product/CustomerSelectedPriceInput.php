<?php

namespace Inttegro\Product;

use Inttegro\Money\AmountParams;

/** Couples a saved customer-selected price with one concrete unit amount. */
final class CustomerSelectedPriceInput extends \Inttegro\DomainValue
{
    public function __construct(
        public readonly string $priceId,
        public readonly AmountParams $selectedAmount,
    ) {}

    public static function fromArray(array $data): static
    {
        $selected = $data['selected_amount'] ?? [];
        return new static(
            (string) ($data['price_id'] ?? ''),
            $selected instanceof AmountParams ? $selected : AmountParams::fromArray(is_array($selected) ? $selected : []),
        );
    }
}
