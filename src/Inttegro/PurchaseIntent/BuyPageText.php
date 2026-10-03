<?php

namespace Inttegro\PurchaseIntent;

/** Merchant-authored copy shown on a hosted Buy page. */
final class BuyPageText extends \Inttegro\DomainValue
{
    public readonly ?string $checkoutSectionTitle;
    public readonly ?string $amountFieldLabel;
    public readonly ?string $primaryActionLabel;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->checkoutSectionTitle = \Inttegro\ValueHydrator::string($data['checkout_section_title'] ?? null, true);
        $this->amountFieldLabel = \Inttegro\ValueHydrator::string($data['amount_field_label'] ?? null, true);
        $this->primaryActionLabel = \Inttegro\ValueHydrator::string($data['primary_action_label'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
