<?php

namespace Inttegro\Request;

use Inttegro\DomainValue;

/** Caller-controlled preferences for computing and representing a successful response. */
final class Response extends DomainValue
{
    /**
     * @param array<string, PropertySelection> $projection Public selections keyed by response resource name.
     */
    public function __construct(public readonly array $projection)
    {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        $projection = [];
        foreach ((array) ($data['projection'] ?? []) as $resource => $selection) {
            $projection[(string) $resource] = PropertySelection::fromArray((array) $selection);
        }
        return new self($projection);
    }
}
