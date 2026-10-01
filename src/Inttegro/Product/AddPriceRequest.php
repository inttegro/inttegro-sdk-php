<?php

namespace Inttegro\Product;

use Inttegro\Money\AmountParams;
use Inttegro\Price\CustomerSelectedAmountParams;
use Inttegro\Price\Type as PriceType;

/** Typed parameters for adding one price to an existing product. */
final class AddPriceRequest extends \Inttegro\DomainValue
{
    public function __construct(
        public readonly string $productId,
        public readonly PriceType $type,
        public readonly ?string $label = null,
        public readonly ?string $about = null,
        public readonly ?AmountParams $fixedAmount = null,
        public readonly ?CustomerSelectedAmountParams $customerSelectedAmount = null,
    ) {
        $fixed = $this->type === PriceType::FixedAmount && $this->fixedAmount !== null && $this->customerSelectedAmount === null;
        $selected = $this->type === PriceType::CustomerSelectedAmount && $this->customerSelectedAmount !== null && $this->fixedAmount === null;
        if ($this->productId === '' || (int) $fixed + (int) $selected !== 1) {
            throw new \InvalidArgumentException('Provide a product ID and exactly one valid price definition.');
        }
    }

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

    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
