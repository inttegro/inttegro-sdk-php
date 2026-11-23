<?php

namespace Inttegro\PaymentMethod;

/** Typed fields accepted by the payment-method update endpoint. */
final class UpdateRequest extends \Inttegro\DomainValue
{
    /** Payment method to update. Required request field. PHP type: `string`; wire field: `payment_method_id` (`string`). */
    public readonly string $paymentMethodId;
    /** Custom-data patch to apply. Optional request field. PHP type: `CustomDataPatch|null`; wire field: `custom_data` (`object`). */
    public readonly ?\Inttegro\CustomDataPatch $customData;
    /** Whether the method is active. Optional request field. PHP type: `bool|null`; wire field: `active` (`boolean`). */
    public readonly ?bool $active;
    /** Whether the method is archived. Optional request field. PHP type: `bool|null`; wire field: `archived` (`boolean`). */
    public readonly ?bool $archived;
    /** Owner fields to patch. Optional request field. PHP type: `UpdateRequestOwner|null`; wire field: `owner` (`object`). */
    public readonly ?UpdateRequestOwner $owner;

    /** Builds a typed payment-method update request. */
    public function __construct(
        string $paymentMethodId,
        ?\Inttegro\CustomDataPatch $customData = null,
        ?bool $active = null,
        ?bool $archived = null,
        ?UpdateRequestOwner $owner = null,
    )
    {
        $this->paymentMethodId = $paymentMethodId;
        $this->customData = $customData;
        $this->active = $active;
        $this->archived = $archived;
        $this->owner = $owner;
    }

    /** Builds a typed request from API wire field names. @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        $customData = $data['custom_data'] ?? null;
        return new static(
            paymentMethodId: \Inttegro\ValueHydrator::string($data['payment_method_id'] ?? null, false),
            customData: $customData instanceof \Inttegro\CustomDataPatch
                ? $customData
                : (is_array($customData) ? new \Inttegro\CustomDataPatch($customData) : null),
            active: \Inttegro\ValueHydrator::bool($data['active'] ?? null, true),
            archived: \Inttegro\ValueHydrator::bool($data['archived'] ?? null, true),
            owner: \Inttegro\ValueHydrator::object($data['owner'] ?? null, [UpdateRequestOwner::class], true),
        );
    }

    /** Returns only request fields explicitly supplied by the caller. @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter(parent::toArray(), static fn(mixed $value): bool => $value !== null);
    }
}
