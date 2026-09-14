<?php

namespace Inttegro\Refund;

/** Masked Ghana bank-account recognition details. */
final class SettlementGhanaBankAccount extends \Inttegro\DomainValue
{
    /** Masked account number in `****1234` form. Wire field: `account_number`. */
    public readonly string $accountNumber;

    /** Final four numeric account digits. Wire field: `last4`. */
    public readonly string $last4;

    /**
     * Hydrates masked Ghana bank-account details from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->accountNumber = \Inttegro\ValueHydrator::string($data['account_number'] ?? null, false);
        $this->last4 = \Inttegro\ValueHydrator::string($data['last4'] ?? null, false);
    }

    /**
     * Creates masked Ghana bank-account details from their API representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
