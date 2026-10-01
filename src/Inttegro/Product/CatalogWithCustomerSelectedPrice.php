<?php

namespace Inttegro\Product;

/** Catalog product using an amount selected under one saved price policy. */
final class CatalogWithCustomerSelectedPrice extends \Inttegro\DomainValue
{
    public function __construct(
        public readonly string $productId,
        public readonly CustomerSelectedPriceInput $customerSelectedPrice,
        public readonly int $quantity,
    ) {}

    public static function fromArray(array $data): static
    {
        $selected = $data['customer_selected_price'] ?? [];
        return new static(
            (string) ($data['product_id'] ?? ''),
            $selected instanceof CustomerSelectedPriceInput ? $selected : CustomerSelectedPriceInput::fromArray(is_array($selected) ? $selected : []),
            (int) ($data['quantity'] ?? 0),
        );
    }
}
