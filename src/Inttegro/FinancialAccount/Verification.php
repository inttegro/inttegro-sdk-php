<?php

namespace Inttegro\FinancialAccount;

use DateTimeImmutable;

/** Financial-account verification state and request evidence. */
final class Verification extends \Inttegro\DomainValue
{
    /** Time verification began. Required response field. PHP type: `DateTimeImmutable`; wire field: `initiated_at` (`string`). */
    public readonly DateTimeImmutable $initiatedAt;
    /** Time verification completed. Optional response field. PHP type: `DateTimeImmutable|null`; wire field: `completed_at` (`string`). */
    public readonly ?DateTimeImmutable $completedAt;
    /** Public request that initiated verification. Required response field. PHP type: `VerificationRequest`; wire field: `request` (`object`). */
    public readonly VerificationRequest $request;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->initiatedAt = \Inttegro\ValueHydrator::dateTime($data['initiated_at'] ?? null, false);
        $this->completedAt = \Inttegro\ValueHydrator::dateTime($data['completed_at'] ?? null, true);
        $this->request = \Inttegro\ValueHydrator::object($data['request'] ?? null, [VerificationRequest::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
