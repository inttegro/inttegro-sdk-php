<?php

namespace Inttegro;

/** Merchant-defined custom-data changes; a null value removes that key. */
final class CustomDataPatch extends CustomDataValue
{
    /** @param array<string, mixed> $values @return array<string, mixed> */
    protected function normalizeValues(array $values): array
    {
        return $values;
    }

    /** Returns a new patch that removes the key when sent. */
    public function removing(string $key): self
    {
        return $this->with($key, null);
    }
}
