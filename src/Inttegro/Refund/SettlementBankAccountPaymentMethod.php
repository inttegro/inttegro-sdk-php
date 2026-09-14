<?php

namespace Inttegro\Refund;

/** Caller-safe bank-account snapshot used as a refund destination. */
final class SettlementBankAccountPaymentMethod extends \Inttegro\DomainValue
{
    /** Public identifier of the original payment method. Wire field: `id`. */
    public readonly string $id;

    /** Required bank-account discriminator. Wire field: `type`. */
    public readonly string $type;

    /** Masked bank-account recognition details. Wire field: `bank_account`. */
    public readonly SettlementBankAccount $bankAccount;

    /**
     * Hydrates a bank-account settlement snapshot from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, false);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, false);
        if ($this->type !== 'bank_account') {
            throw new \InvalidArgumentException('Invalid bank-account refund settlement.');
        }
        $this->bankAccount = \Inttegro\ValueHydrator::object(
            $data['bank_account'] ?? null,
            [SettlementBankAccount::class],
            false,
        );
    }

    /**
     * Creates a bank-account settlement snapshot from its API representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
