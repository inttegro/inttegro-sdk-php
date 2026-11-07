<?php

namespace Inttegro\Request;

use Inttegro\DomainValue;

/** Typed controls for one API request that do not change its domain payload. */
final class Meta extends DomainValue
{
    public function __construct(
        public readonly ?string $idempotencyKey = null,
        public readonly ?Response $response = null,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            isset($data['idempotency_key']) ? (string) $data['idempotency_key'] : null,
            isset($data['response']) ? Response::fromArray((array) $data['response']) : null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $data = [];
        if ($this->idempotencyKey !== null) {
            $data['idempotency_key'] = $this->idempotencyKey;
        }
        if ($this->response !== null) {
            $data['response'] = $this->response->toArray();
        }
        return $data;
    }
}
