<?php

namespace Inttegro;

use UnexpectedValueException;

/** Merchant-defined string values returned with an Inttegro resource. */
final class CustomData extends CustomDataValue
{
    /** @param array<string, mixed> $values @return array<string, string> */
    protected function normalizeValues(array $values): array
    {
        foreach ($values as $value) {
            if (!is_string($value)) {
                throw new UnexpectedValueException('Returned custom-data values must be strings.');
            }
        }
        /** @var array<string, string> $values */
        return $values;
    }

    /** @param array<string, string> $values */
    public static function fromArray(array $values): self
    {
        return new self($values);
    }
}
