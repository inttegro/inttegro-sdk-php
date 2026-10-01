<?php

namespace Inttegro\Price;

use Inttegro\Money\Currency;

/** Currency, range, and optional conveniences for a selected amount. */
final class CustomerSelectedAmountParams extends \Inttegro\DomainValue
{
    /**
     * Creates a customer-selected catalog price policy request.
     *
     * @param list<SuggestedAmountParams>|null $suggestedAmounts Optional choices. Wire field: `suggested_amounts` (`array`).
     */
    public function __construct(
        /** Required. PHP type: `Currency`; wire field: `currency` (`string`). */
        public readonly Currency $currency,
        /** Required. PHP type: `int`; wire field: `minimum` (`integer` minor units). */
        public readonly int $minimum,
        /** Optional. PHP type: `int|null`; wire field: `maximum` (`integer` minor units). */
        public readonly ?int $maximum = null,
        /** Optional. PHP type: `list<SuggestedAmountParams>|null`; wire field: `suggested_amounts` (`array`). */
        public readonly ?array $suggestedAmounts = null,
    ) {}

    /**
     * Creates the policy parameters from a decoded API wire object.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        $currency = $data['currency'] ?? Currency::GHS;
        $suggestions = isset($data['suggested_amounts']) && is_array($data['suggested_amounts'])
            ? array_map(
                static fn(mixed $item): SuggestedAmountParams => SuggestedAmountParams::fromArray(is_array($item) ? $item : []),
                array_values($data['suggested_amounts']),
            )
            : null;

        return new static(
            $currency instanceof Currency ? $currency : Currency::from(strtolower((string) $currency)),
            (int) ($data['minimum'] ?? 0),
            isset($data['maximum']) ? (int) $data['maximum'] : null,
            $suggestions,
        );
    }

    /** Returns the `snake_case` request payload without null optional fields. */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
