<?php

namespace Inttegro\PaymentMethod;

/** Postal address fields accepted when updating a payment-method owner. */
final class UpdateRequestOwnerAddress extends \Inttegro\DomainValue
{
    /** Updated city or locality. Optional request field. PHP type: `string|null`; wire field: `city` (`string`). */
    public readonly ?string $city;
    /** Updated two-letter country code. Optional request field. PHP type: `string|null`; wire field: `country` (`string`). */
    public readonly ?string $country;
    /** Updated first address line. Optional request field. PHP type: `string|null`; wire field: `line1` (`string`). */
    public readonly ?string $line1;
    /** Updated second address line. Optional request field. PHP type: `string|null`; wire field: `line2` (`string`). */
    public readonly ?string $line2;
    /** Updated recipient name. Optional request field. PHP type: `string|null`; wire field: `name` (`string`). */
    public readonly ?string $name;
    /** Updated phone number. Optional request field. PHP type: `string|null`; wire field: `phone_number` (`string`). */
    public readonly ?string $phoneNumber;
    /** Updated postal code. Optional request field. PHP type: `string|null`; wire field: `post_code` (`string`). */
    public readonly ?string $postCode;
    /** Updated region, state, or province. Optional request field. PHP type: `string|null`; wire field: `region` (`string`). */
    public readonly ?string $region;

    /** Builds the address portion of a payment-method owner update. */
    public function __construct(
        ?string $city = null,
        ?string $country = null,
        ?string $line1 = null,
        ?string $line2 = null,
        ?string $name = null,
        ?string $phoneNumber = null,
        ?string $postCode = null,
        ?string $region = null,
    )
    {
        $this->city = $city;
        $this->country = $country;
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->postCode = $postCode;
        $this->region = $region;
    }

    /** Builds address fields from API wire names. @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static(
            city: \Inttegro\ValueHydrator::string($data['city'] ?? null, true),
            country: \Inttegro\ValueHydrator::string($data['country'] ?? null, true),
            line1: \Inttegro\ValueHydrator::string($data['line1'] ?? null, true),
            line2: \Inttegro\ValueHydrator::string($data['line2'] ?? null, true),
            name: \Inttegro\ValueHydrator::string($data['name'] ?? null, true),
            phoneNumber: \Inttegro\ValueHydrator::string($data['phone_number'] ?? null, true),
            postCode: \Inttegro\ValueHydrator::string($data['post_code'] ?? null, true),
            region: \Inttegro\ValueHydrator::string($data['region'] ?? null, true),
        );
    }

    /** Returns only address fields explicitly supplied by the caller. @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
