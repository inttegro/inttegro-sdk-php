<?php

namespace Inttegro\Price;

use Inttegro\Money\Currency;

/** Currency, range, and optional conveniences for a selected amount. */
final class CustomerSelectedAmountParams extends \Inttegro\DomainValue
{
    /** @param list<SuggestedAmountParams>|null $suggestedAmounts */
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

    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
