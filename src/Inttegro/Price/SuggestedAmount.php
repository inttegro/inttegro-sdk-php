<?php

namespace Inttegro\Price;

/** A convenient amount choice returned with a catalog price. */
final class SuggestedAmount extends \Inttegro\DomainValue
{
    /** Creates a suggested amount returned with a catalog price. */
    public function __construct(
        /** Required. PHP type: `string`; wire field: `id` (`string`). */
        public readonly string $id,
        /** Required. PHP type: `int`; wire field: `value` (`integer` minor units). */
        public readonly int $value,
        /** Optional. PHP type: `bool|null`; wire field: `recommended` (`boolean`). */
        public readonly ?bool $recommended = null,
    ) {}

    /**
     * Creates the suggestion from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static(
            (string) ($data['id'] ?? ''),
            (int) ($data['value'] ?? 0),
            isset($data['recommended']) ? (bool) $data['recommended'] : null,
        );
    }
}
