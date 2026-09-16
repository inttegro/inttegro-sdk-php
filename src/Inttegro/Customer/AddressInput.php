<?php

namespace Inttegro\Customer;

/** Typed postal address accepted by customer create and update requests. */
final class AddressInput extends \Inttegro\DomainValue
{
    /** Optional city. PHP type: `string|null`; wire field: `city` (`string`). */
    public readonly ?string $city;

    /** Required ISO 3166-1 alpha-2 country code. PHP type: `string`; wire field: `country` (`string`). */
    public readonly string $country;

    /** Optional first address line. PHP type: `string|null`; wire field: `line1` (`string`). */
    public readonly ?string $line1;

    /** Optional second address line. PHP type: `string|null`; wire field: `line2` (`string`). */
    public readonly ?string $line2;

    /** Optional recipient name. PHP type: `string|null`; wire field: `name` (`string`). */
    public readonly ?string $name;

    /** Optional recipient phone number. PHP type: `string|null`; wire field: `phone_number` (`string`). */
    public readonly ?string $phoneNumber;

    /** Optional postal code. PHP type: `string|null`; wire field: `post_code` (`string`). */
    public readonly ?string $postCode;

    /** Optional state, province, or region. PHP type: `string|null`; wire field: `region` (`string`). */
    public readonly ?string $region;

    /**
     * @param array{
     *   country: string,
     *   city?: string|null,
     *   line1?: string|null,
     *   line2?: string|null,
     *   name?: string|null,
     *   phone_number?: string|null,
     *   post_code?: string|null,
     *   region?: string|null
     * } $data
     */
    public function __construct(array $data)
    {
        $this->city = \Inttegro\ValueHydrator::string($data['city'] ?? null, true);
        $this->country = \Inttegro\ValueHydrator::string($data['country'], false);
        $this->line1 = \Inttegro\ValueHydrator::string($data['line1'] ?? null, true);
        $this->line2 = \Inttegro\ValueHydrator::string($data['line2'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->phoneNumber = \Inttegro\ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->postCode = \Inttegro\ValueHydrator::string($data['post_code'] ?? null, true);
        $this->region = \Inttegro\ValueHydrator::string($data['region'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
