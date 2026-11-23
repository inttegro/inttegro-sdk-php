<?php

namespace Inttegro\Chime;

/** Effective, non-secret Chime delivery settings. */
final class Settings extends \Inttegro\DomainValue
{
    /**
     * Effective SMS delivery settings.
     *
     * Required response field. PHP type: `\Inttegro\Chime\SMSSettings`; wire field: `sms` (`object`).
     */
    public readonly SMSSettings $sms;

    /**
     * Effective email delivery settings.
     *
     * Required response field. PHP type: `\Inttegro\Chime\EmailSettings`; wire field: `email` (`object`).
     */
    public readonly EmailSettings $email;

    /** @param array<string, mixed> $data Wire object keyed by `snake_case` API field names. */
    public function __construct(array $data)
    {
        $this->sms = \Inttegro\ValueHydrator::object($data['sms'] ?? null, [SMSSettings::class], false);
        $this->email = \Inttegro\ValueHydrator::object($data['email'] ?? null, [EmailSettings::class], false);
    }

    /**
     * Creates settings from their decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static Typed, immutable Chime settings.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
