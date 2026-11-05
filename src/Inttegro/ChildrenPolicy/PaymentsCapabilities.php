<?php

namespace Inttegro\ChildrenPolicy;

/** Payment choices and amount bounds available to child applications. */
final class PaymentsCapabilities extends \Inttegro\DomainValue
{
    /** Allowed currencies; PHP type: `list<string>`; wire field: `currencies` (`array`). @var list<string>|null */
    public readonly ?array $currencies;
    /** Allowed payment limits; PHP type: `Limits|null`; wire field: `limits` (`object`). */
    public readonly ?Limits $limits;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $this->currencies = \Inttegro\ValueHydrator::array($data['currencies'] ?? null, true);
        $this->limits = \Inttegro\ValueHydrator::object($data['limits'] ?? null, [Limits::class], true);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
