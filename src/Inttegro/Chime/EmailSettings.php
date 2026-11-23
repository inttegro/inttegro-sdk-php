<?php

namespace Inttegro\Chime;

/** Effective email sender defaults and allowed From addresses. */
final class EmailSettings extends \Inttegro\DomainValue
{
    /** Platform fallback From address. Required response field; PHP type: `string`; wire field: `default_from`. */
    public readonly string $defaultFrom;

    /**
     * From addresses authorized for reusable templates.
     *
     * Required response field. PHP type: `list<string>`; wire field: `allowed_from` (`array<string>`).
     *
     * @var list<string>
     */
    public readonly array $allowedFrom;

    /** @param array<string, mixed> $data Wire object keyed by `snake_case` API field names. */
    public function __construct(array $data)
    {
        $this->defaultFrom = \Inttegro\ValueHydrator::string($data['default_from'] ?? null, false);
        $this->allowedFrom = \Inttegro\ValueHydrator::array($data['allowed_from'] ?? null, false);
    }

    /**
     * Creates email settings from their decoded API wire representation.
     *
     * @param array<string, mixed> $data Wire object keyed by `snake_case` API field names.
     * @return static Typed, immutable email settings.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
