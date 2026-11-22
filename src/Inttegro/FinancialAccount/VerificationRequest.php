<?php

namespace Inttegro\FinancialAccount;

/** Identifies a financial-account verification request and mechanism. */
final class VerificationRequest extends \Inttegro\DomainValue
{
    /** Verification request identifier. Optional response field. PHP type: `string|null`; wire field: `id` (`string`). */
    public readonly ?string $id;
    /** Verification mechanism. Optional response field. PHP type: `string|null`; wire field: `mechanism` (`string`). */
    public readonly ?string $mechanism;
    /** Verification request type. Optional response field. PHP type: `string|null`; wire field: `type` (`string`). */
    public readonly ?string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = \Inttegro\ValueHydrator::string($data['id'] ?? null, true);
        $this->mechanism = \Inttegro\ValueHydrator::string($data['mechanism'] ?? null, true);
        $this->type = \Inttegro\ValueHydrator::string($data['type'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static { return new static($data); }
}
