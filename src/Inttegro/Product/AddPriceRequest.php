<?php

namespace Inttegro\Product;

use Inttegro\Money\AmountParams;
use Inttegro\Price\CustomerSelectedAmountParams;
use Inttegro\Price\Type as PriceType;

/** Typed parameters for adding one price to an existing product. */
final class AddPriceRequest extends \Inttegro\DomainValue
{
    /** Creates a validated typed price addition request. */
    public function __construct(
        /** Required. PHP type: `string`; wire field: `product_id` (`string`). */
        public readonly string $productId,
        /** Required. PHP type: `PriceType`; wire field: `type` (`string`). */
        public readonly PriceType $type,
        /** Optional. PHP type: `string|null`; wire field: `label` (`string`). */
        public readonly ?string $label = null,
        /** Optional. PHP type: `string|null`; wire field: `about` (`string`). */
        public readonly ?string $about = null,
        /** Required for fixed prices. PHP type: `AmountParams|null`; wire field: `fixed_amount` (`object`). */
        public readonly ?AmountParams $fixedAmount = null,
        /** Required for selected prices. PHP type: `CustomerSelectedAmountParams|null`; wire field: `customer_selected_amount` (`object`). */
        public readonly ?CustomerSelectedAmountParams $customerSelectedAmount = null,
    ) {
        $fixed = $this->type === PriceType::FixedAmount && $this->fixedAmount !== null && $this->customerSelectedAmount === null;
        $selected = $this->type === PriceType::CustomerSelectedAmount && $this->customerSelectedAmount !== null && $this->fixedAmount === null;
        if ($this->productId === '' || (int) $fixed + (int) $selected !== 1) {
            throw new \InvalidArgumentException('Provide a product ID and exactly one valid price definition.');
        }
    }

    /** Creates the request from a decoded API wire object. */
    public static function fromArray(array $data): static
    {
        $type = $data['type'] ?? null;
        $fixedAmount = $data['fixed_amount'] ?? null;
        $selectedAmount = $data['customer_selected_amount'] ?? null;
        return new static(
            (string) ($data['product_id'] ?? ''),
            $type instanceof PriceType ? $type : PriceType::from((string) $type),
            isset($data['label']) ? (string) $data['label'] : null,
            isset($data['about']) ? (string) $data['about'] : null,
            $fixedAmount instanceof AmountParams ? $fixedAmount : (is_array($fixedAmount) ? AmountParams::fromArray($fixedAmount) : null),
            $selectedAmount instanceof CustomerSelectedAmountParams ? $selectedAmount : (is_array($selectedAmount) ? CustomerSelectedAmountParams::fromArray($selectedAmount) : null),
        );
    }

    /** Returns the `snake_case` request payload without null optional fields. */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
