<?php

namespace Inttegro\Product;

use Inttegro\Money\AmountParams;

/** Couples a saved customer-selected price with one concrete unit amount. */
final class CustomerSelectedPriceInput extends \Inttegro\DomainValue
{
    /** Creates a price-and-amount selection for one order line item. */
    public function __construct(
        /** Required. PHP type: `string`; wire field: `price_id` (`string`). */
        public readonly string $priceId,
        /** Required. PHP type: `AmountParams`; wire field: `selected_amount` (`object`). */
        public readonly AmountParams $selectedAmount,
    ) {}

    /**
     * Creates the selection from a decoded API wire object.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        $selected = $data['selected_amount'] ?? [];
        return new static(
            (string) ($data['price_id'] ?? ''),
            $selected instanceof AmountParams ? $selected : AmountParams::fromArray(is_array($selected) ? $selected : []),
        );
    }
}
