<?php

namespace Inttegro\Refund;

/** Supported bank-account subtype and its masked details. */
final class SettlementBankAccount extends \Inttegro\DomainValue
{
    /** Required country-specific account discriminator. Wire field: `type`. */
    public readonly string $type;

    /** Masked Ghana bank-account recognition details. Wire field: `ghana_bank_account`. */
    public readonly SettlementGhanaBankAccount $ghanaBankAccount;

    /**
     * Hydrates a supported bank-account snapshot from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'ghana_bank_account') {
            throw new \InvalidArgumentException('Unsupported refund bank-account settlement type.');
        }
        $this->ghanaBankAccount = \Inttegro\ValueHydrator::object(
            $data['ghana_bank_account'] ?? null,
            [SettlementGhanaBankAccount::class],
            false,
        );
    }

    /**
     * Creates a supported bank-account snapshot from its API representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
