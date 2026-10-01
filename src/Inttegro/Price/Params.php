<?php

namespace Inttegro\Price;

use Inttegro\Money\AmountParams;

/**
 * Typed parameters for creating a reusable catalog price.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class Params extends \Inttegro\DomainValue
{
    /**
     * Creates typed parameters for a catalog price.
     *
     * Nullable properties are omitted by `toArray()` so the API can apply its defaults.
     *
     * @param Type $type Required price definition discriminator. Wire field: `type` (`string`).
     * @param string|null $productId Optional for fixed prices and required for customer-selected prices. Wire field: `product_id` (`string`).
     * @param string|null $label Optional customer-facing label. Wire field: `label` (`string`).
     * @param string|null $about Optional explanatory text. Wire field: `about` (`string`).
     */
    public function __construct(
        /** Required. PHP type: `Type`; wire field: `type` (`string`). */
        public readonly Type $type,
        /** Optional. PHP type: `string|null`; wire field: `product_id` (`string`). */
        public readonly ?string $productId = null,
        /** Optional. PHP type: `string|null`; wire field: `label` (`string`). */
        public readonly ?string $label = null,
        /** Optional. PHP type: `string|null`; wire field: `about` (`string`). */
        public readonly ?string $about = null,
        /** Required for a typed fixed price. */
        public readonly ?AmountParams $fixedAmount = null,
        /** Required for a customer-selected price. */
        public readonly ?CustomerSelectedAmountParams $customerSelectedAmount = null,
    ) {
        $fixed = $this->type === Type::FixedAmount && $this->fixedAmount !== null && $this->customerSelectedAmount === null;
        $selected = $this->type === Type::CustomerSelectedAmount && $this->customerSelectedAmount !== null && $this->fixedAmount === null && $this->productId !== null && $this->productId !== '';
        if ((int) $fixed + (int) $selected !== 1) {
            throw new \InvalidArgumentException('Provide exactly one valid catalog price definition.');
        }
    }

    /**
     * Creates a Params from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable Params value.
     */
    public static function fromArray(array $data): static
    {
        $type = $data['type'] ?? null;
        $fixedAmount = $data['fixed_amount'] ?? null;
        $selectedAmount = $data['customer_selected_amount'] ?? null;

        return new static(
            $type instanceof Type ? $type : Type::from((string) $type),
            isset($data['product_id']) ? (string) $data['product_id'] : null,
            isset($data['label']) ? (string) $data['label'] : null,
            isset($data['about']) ? (string) $data['about'] : null,
            $fixedAmount instanceof AmountParams ? $fixedAmount : (is_array($fixedAmount) ? AmountParams::fromArray($fixedAmount) : null),
            $selectedAmount instanceof CustomerSelectedAmountParams ? $selectedAmount : (is_array($selectedAmount) ? CustomerSelectedAmountParams::fromArray($selectedAmount) : null),
        );
    }

    /**
     * Returns the API wire object and omits every optional field whose value is null.
     *
     * @return array<string, mixed> A `snake_case` request payload.
     */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
