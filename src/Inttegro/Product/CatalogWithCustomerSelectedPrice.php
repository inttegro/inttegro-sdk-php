<?php

namespace Inttegro\Product;

/** Catalog product using an amount selected under one saved price policy. */
final class CatalogWithCustomerSelectedPrice extends \Inttegro\DomainValue
{
    /** Creates a catalog product order-line request with a selected amount. */
    public function __construct(
        /** Required. PHP type: `string`; wire field: `product_id` (`string`). */
        public readonly string $productId,
        /** Required. PHP type: `CustomerSelectedPriceInput`; wire field: `customer_selected_price` (`object`). */
        public readonly CustomerSelectedPriceInput $customerSelectedPrice,
        /** Required. PHP type: `int`; wire field: `quantity` (`integer`). */
        public readonly int $quantity,
    ) {}

    /**
     * Creates the catalog line item from a decoded API wire object.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
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
