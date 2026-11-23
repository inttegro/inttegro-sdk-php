<?php

namespace Inttegro\Chime;

/** Effective SMS sender defaults and limits. */
final class SMSSettings extends \Inttegro\DomainValue
{
    /** Platform fallback sender ID. Required response field; PHP type: `string`; wire field: `default_sender`. */
    public readonly string $defaultSender;

    /** Minimum accepted sender length. Required response field; PHP type: `int`; wire field: `min_sender_char_len`. */
    public readonly int $minSenderCharLen;

    /** Maximum accepted sender length. Required response field; PHP type: `int`; wire field: `max_sender_char_len`. */
    public readonly int $maxSenderCharLen;

    /** @param array<string, mixed> $data Wire object keyed by `snake_case` API field names. */
    public function __construct(array $data)
    {
        $this->defaultSender = \Inttegro\ValueHydrator::string($data['default_sender'] ?? null, false);
        $this->minSenderCharLen = \Inttegro\ValueHydrator::int($data['min_sender_char_len'] ?? null, false);
        $this->maxSenderCharLen = \Inttegro\ValueHydrator::int($data['max_sender_char_len'] ?? null, false);
    }

    /**
     * Creates SMS settings from their decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static Typed, immutable SMS settings.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
