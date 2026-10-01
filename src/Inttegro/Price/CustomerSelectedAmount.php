<?php

namespace Inttegro\Price;

use Inttegro\Money\Currency;

/** Persisted currency, range, and suggestions for a selected amount. */
final class CustomerSelectedAmount extends \Inttegro\DomainValue
{
    /**
     * Creates a customer-selected price policy returned by the API.
     *
     * @param list<SuggestedAmount>|null $suggestedAmounts Optional choices. Wire field: `suggested_amounts` (`array`).
     */
    public function __construct(
        /** Required. PHP type: `Currency`; wire field: `currency` (`string`). */
        public readonly Currency $currency,
        /** Required. PHP type: `int`; wire field: `minimum` (`integer` minor units). */
        public readonly int $minimum,
        /** Optional. PHP type: `int|null`; wire field: `maximum` (`integer` minor units). */
        public readonly ?int $maximum = null,
        /** Optional. PHP type: `list<SuggestedAmount>|null`; wire field: `suggested_amounts` (`array`). */
        public readonly ?array $suggestedAmounts = null,
    ) {}

    /**
     * Creates the policy from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        $currency = $data['currency'] ?? Currency::GHS;
        $suggestions = isset($data['suggested_amounts']) && is_array($data['suggested_amounts'])
            ? array_map(
                static fn(mixed $item): SuggestedAmount => SuggestedAmount::fromArray(is_array($item) ? $item : []),
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
}
