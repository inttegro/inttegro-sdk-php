<?php

namespace Inttegro\Customer;

/** Typed fields for updating a customer. */
final class UpdateRequest extends \Inttegro\DomainValue
{
    /** Replacement billing address. PHP type: `AddressInput|null`; wire field: `billing_address` (`object`). */
    public readonly ?AddressInput $billingAddress;

    /** Replacement merchant-defined values. PHP type: `CustomDataInput|null`; wire field: `custom_data` (`object`). */
    public readonly ?\Inttegro\CustomDataInput $customData;

    /** Customer to update. PHP type: `string`; wire field: `customer_id` (`string`). */
    public readonly string $customerId;

    /** Replacement email address. PHP type: `string|null`; wire field: `email_address` (`string`). */
    public readonly ?string $emailAddress;

    /** Replacement customer name. PHP type: `string|null`; wire field: `name` (`string`). */
    public readonly ?string $name;

    /** Replacement phone number. PHP type: `string|null`; wire field: `phone_number` (`string`). */
    public readonly ?string $phoneNumber;

    /** Replacement merchant reference. PHP type: `string|null`; wire field: `reference` (`string`). */
    public readonly ?string $reference;

    /** Replacement shipping address. PHP type: `AddressInput|null`; wire field: `shipping_address` (`object`). */
    public readonly ?AddressInput $shippingAddress;

    /** Replacement name suffix. PHP type: `string|null`; wire field: `suffix` (`string`). */
    public readonly ?string $suffix;

    /** Replacement title. PHP type: `string|null`; wire field: `title` (`string`). */
    public readonly ?string $title;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->billingAddress = self::address($data['billing_address'] ?? null);
        $this->customData = self::customData($data['custom_data'] ?? null);
        $this->customerId = \Inttegro\ValueHydrator::string($data['customer_id'] ?? null, false);
        $this->emailAddress = \Inttegro\ValueHydrator::string($data['email_address'] ?? null, true);
        $this->name = \Inttegro\ValueHydrator::string($data['name'] ?? null, true);
        $this->phoneNumber = \Inttegro\ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->reference = \Inttegro\ValueHydrator::string($data['reference'] ?? null, true);
        $this->shippingAddress = self::address($data['shipping_address'] ?? null);
        $this->suffix = \Inttegro\ValueHydrator::string($data['suffix'] ?? null, true);
        $this->title = \Inttegro\ValueHydrator::string($data['title'] ?? null, true);
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

    private static function address(mixed $value): ?AddressInput
    {
        if ($value === null || $value instanceof AddressInput) return $value;
        return AddressInput::fromArray(is_array($value) ? $value : []);
    }

    private static function customData(mixed $value): ?\Inttegro\CustomDataInput
    {
        if ($value === null || $value instanceof \Inttegro\CustomDataInput) return $value;
        return new \Inttegro\CustomDataInput(is_array($value) ? $value : []);
    }
}
