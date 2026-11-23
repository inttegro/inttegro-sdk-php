<?php

namespace Inttegro\PaymentMethod;

/** Owner fields accepted when updating a payment method. */
final class UpdateRequestOwner extends \Inttegro\DomainValue
{
    /** Updated owner name. Optional request field. PHP type: `string|null`; wire field: `name` (`string`). */
    public readonly ?string $name;
    /** Updated owner address. Optional request field. PHP type: `UpdateRequestOwnerAddress|null`; wire field: `address` (`object`). */
    public readonly ?UpdateRequestOwnerAddress $address;

    /** Builds the owner portion of a payment-method update. */
    public function __construct(?string $name = null, ?UpdateRequestOwnerAddress $address = null)
    {
        $this->name = $name;
        $this->address = $address;
    }

    /** Builds owner fields from API wire names. @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static(
            name: \Inttegro\ValueHydrator::string($data['name'] ?? null, true),
            address: \Inttegro\ValueHydrator::object(
                $data['address'] ?? null,
                [UpdateRequestOwnerAddress::class],
                true,
            ),
        );
    }

    /** Returns only owner fields explicitly supplied by the caller. @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
