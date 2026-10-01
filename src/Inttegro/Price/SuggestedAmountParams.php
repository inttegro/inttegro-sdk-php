<?php

namespace Inttegro\Price;

/** A convenient amount choice; suggestions do not restrict valid amounts. */
final class SuggestedAmountParams extends \Inttegro\DomainValue
{
    /** Creates one suggested amount in a catalog price request. */
    public function __construct(
        /** Required. PHP type: `string`; wire field: `id` (`string`). */
        public readonly string $id,
        /** Required. PHP type: `int`; wire field: `value` (`integer` minor units). */
        public readonly int $value,
        /** Optional. PHP type: `bool|null`; wire field: `recommended` (`boolean`). */
        public readonly ?bool $recommended = null,
    ) {}

    /**
     * Creates the suggestion parameters from a decoded API wire object.
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

    /** Returns the `snake_case` request payload without null optional fields. */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
