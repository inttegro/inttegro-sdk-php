<?php

namespace Inttegro;

/** Merchant-defined JSON values accepted when a resource is created or replaced. */
final class CustomDataInput extends CustomDataValue
{
    /** @param array<string, mixed> $values @return array<string, mixed> */
    protected function normalizeValues(array $values): array
    {
        return $values;
    }
}
