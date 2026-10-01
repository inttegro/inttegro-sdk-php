<?php

namespace Inttegro\Price;

/** A convenient amount choice returned with a catalog price. */
final class SuggestedAmount extends \Inttegro\DomainValue
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
}
