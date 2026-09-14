<?php

namespace Inttegro\Refund;

/** Masked mobile-money recognition details. */
final class SettlementMobileMoney extends \Inttegro\DomainValue
{
    /** Mobile-money network used by the original method. Wire field: `network`. */
    public readonly string $network;

    /** Masked account number in `****1234` form. Wire field: `account_number`. */
    public readonly string $accountNumber;

    /** Final four numeric account digits. Wire field: `last4`. */
    public readonly string $last4;

    /**
     * Hydrates masked mobile-money details from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->network = \Inttegro\ValueHydrator::string($data['network'] ?? null, false);
        $this->accountNumber = \Inttegro\ValueHydrator::string($data['account_number'] ?? null, false);
        $this->last4 = \Inttegro\ValueHydrator::string($data['last4'] ?? null, false);
    }

    /**
     * Creates masked mobile-money details from their API representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
