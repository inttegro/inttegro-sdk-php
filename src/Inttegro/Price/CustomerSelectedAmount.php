<?php

namespace Inttegro\Price;

use Inttegro\Money\Currency;

/** Persisted currency, range, and suggestions for a selected amount. */
final class CustomerSelectedAmount extends \Inttegro\DomainValue
{
    /** @param list<SuggestedAmount>|null $suggestedAmounts */
    public function __construct(
        public readonly Currency $currency,
        public readonly int $minimum,
        public readonly ?int $maximum = null,
        public readonly ?array $suggestedAmounts = null,
    ) {}

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
