<?php

namespace Inttegro;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use LogicException;
use Traversable;
use UnexpectedValueException;

/**
 * Immutable base for Inttegro custom-data collections.
 *
 * The wrapper keeps open-ended merchant keys while preventing in-place mutation. Use `with()` and
 * `without()` to derive a replacement value before sending a create or update request.
 *
 * @implements ArrayAccess<string, mixed>
 * @implements IteratorAggregate<string, mixed>
 * @phpstan-consistent-constructor
 */
abstract class CustomDataValue implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable
{
    private const MAX_KEY_BYTES = 256;
    private const MAX_ENCODED_BYTES = 25 * 1024;

    /** @var array<string, mixed> */
    private array $values;

    /** @param array<string, mixed> $values */
    public function __construct(array $values = [])
    {
        $normalized = $this->normalizeValues($values);
        foreach (array_keys($normalized) as $key) {
            if (!is_string($key)) {
                throw new UnexpectedValueException('Custom-data keys must be strings.');
            }
            if (strlen($key) > self::MAX_KEY_BYTES) {
                throw new UnexpectedValueException('Custom-data keys may not exceed 256 bytes.');
            }
        }

        $encoded = json_encode($normalized, JSON_THROW_ON_ERROR);
        if (strlen($encoded) > self::MAX_ENCODED_BYTES) {
            throw new UnexpectedValueException('Custom data may not exceed 25 KiB when encoded.');
        }
        /** @var array<string, mixed> $copy */
        $copy = json_decode($encoded, true, 512, JSON_THROW_ON_ERROR);
        $this->values = $copy;
    }

    /** @param array<string, mixed> $values @return array<string, mixed> */
    abstract protected function normalizeValues(array $values): array;

    /** Returns a new collection with one key set. */
    public function with(string $key, mixed $value): static
    {
        return new static([...$this->values, $key => $value]);
    }

    /** Returns a new collection without one key or pending change. */
    public function without(string $key): static
    {
        $values = $this->values;
        unset($values[$key]);
        return new static($values);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->values;
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function count(): int
    {
        return count($this->values);
    }

    /** @return Traversable<string, mixed> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->values);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->values);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->values[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Inttegro custom-data values are immutable; use with().');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Inttegro custom-data values are immutable; use without().');
    }
}
