<?php

namespace Inttegro\Product;

use Inttegro\Money\Amount;
use Inttegro\Price\CustomerSelectedAmount;
use Inttegro\Price\Type as PriceType;

/**
 * Price Summary details associated with product.
 *
 * This immutable value hydrates decoded API `snake_case` data into typed `camelCase` properties.
 * Use `fromArray()` for wire data; `toArray()`, array access, and JSON serialization expose the API
 * wire representation. Nullable properties correspond to optional API fields.
 *
 * @see \Inttegro\DomainValue
 */
final class PriceSummary extends \Inttegro\DomainValue
{
    /**
     * Unique price identifier with pr_ prefix.
     *
     * Required response field. PHP type: `string`; wire field: `id` (`string`).
     *
     * @var string
     */
    public readonly string $id;

    /**
     * Whether this price is active and usable in new flows.
     *
     * Required response field. PHP type: `bool`; wire field: `active` (`boolean`).
     *
     * @var bool
     */
    public readonly bool $active;

    /**
     * Short label for this price.
     *
     * Optional response field. PHP type: `string|null`; wire field: `label` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $label;

    /** Required. PHP type: `PriceType`; wire field: `type` (`string`). */
    public readonly PriceType $type;

    /** Optional deprecated alias. PHP type: `Amount|null`; wire field: `nominal` (`object`). */
    public readonly ?Amount $nominal;

    /** Optional. PHP type: `Amount|null`; wire field: `fixed_amount` (`object`). */
    public readonly ?Amount $fixedAmount;

    /** Optional. PHP type: `CustomerSelectedAmount|null`; wire field: `customer_selected_amount` (`object`). */
    public readonly ?CustomerSelectedAmount $customerSelectedAmount;

    /**
     * Hydrates a PriceSummary from decoded Inttegro API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->active = \Inttegro\ValueHydrator::bool($data['active'] ?? null, false);
        $this->label = \Inttegro\ValueHydrator::string($data['label'] ?? null, true);
        $this->type = PriceType::from(\Inttegro\ValueHydrator::string($data['type'] ?? null, false));
        $this->nominal = \Inttegro\ValueHydrator::object($data['nominal'] ?? null, [Amount::class], true);
        $this->fixedAmount = \Inttegro\ValueHydrator::object($data['fixed_amount'] ?? null, [Amount::class], true);
        $this->customerSelectedAmount = \Inttegro\ValueHydrator::object($data['customer_selected_amount'] ?? null, [CustomerSelectedAmount::class], true);
    }

    /**
     * Creates a PriceSummary from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static A typed, immutable PriceSummary value.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
