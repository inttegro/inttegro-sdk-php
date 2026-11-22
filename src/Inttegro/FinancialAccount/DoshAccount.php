<?php

namespace Inttegro\FinancialAccount;

/** Public marker for a Dosh account; credentials are never exposed. */
final class DoshAccount extends \Inttegro\DomainValue
{
    /** Creates the public empty Dosh-account marker. */
    public function __construct() {}

    /** Creates the marker from its empty API object. @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        if ($data !== []) {
            throw new \InvalidArgumentException('DoshAccount must be an empty object.');
        }
        return new static();
    }
}
