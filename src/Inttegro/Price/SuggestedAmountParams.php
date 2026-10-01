<?php

namespace Inttegro\Price;

/** A convenient amount choice; suggestions do not restrict valid amounts. */
final class SuggestedAmountParams extends \Inttegro\DomainValue
{
    public function __construct(
        public readonly string $id,
        public readonly int $value,
        public readonly ?bool $recommended = null,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            (string) ($data['id'] ?? ''),
            (int) ($data['value'] ?? 0),
            isset($data['recommended']) ? (bool) $data['recommended'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
