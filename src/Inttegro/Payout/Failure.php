<?php

namespace Inttegro\Payout;

/** Caller-safe information about a terminal payout failure. */
final class Failure extends \Inttegro\DomainValue
{
    /** Safe operator-facing explanation. Wire field: `detail`. */
    public readonly string $detail;

    /** Stable caller-safe classification. Wire field: `reason`. */
    public readonly FailureReason $reason;

    /** Whether creating a new payout attempt may succeed. Wire field: `retryable`. */
    public readonly bool $retryable;

    /**
     * Hydrates a failure from decoded API data.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public function __construct(array $data)
    {
        $this->detail = \Inttegro\ValueHydrator::string($data['detail'] ?? null, false);
        $this->reason = FailureReason::from(
            \Inttegro\ValueHydrator::string($data['reason'] ?? null, false),
        );
        $this->retryable = \Inttegro\ValueHydrator::bool($data['retryable'] ?? null, false);
    }

    /**
     * Creates a failure from its decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
