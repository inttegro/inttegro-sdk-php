<?php

namespace Inttegro\Order;

/** Hosted document formats for an order payment receipt. */
final class ReceiptFormat extends \Inttegro\DomainValue
{
    /**
     * Hosted receipt page.
     *
     * Required response field. PHP type: `DocumentFormat`; wire field: `web` (`object`).
     *
     * @var DocumentFormat
     */
    public readonly DocumentFormat $web;

    /**
     * Receipt PDF.
     *
     * Required response field. PHP type: `DocumentFormat`; wire field: `pdf` (`object`).
     *
     * @var DocumentFormat
     */
    public readonly DocumentFormat $pdf;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->web = \Inttegro\ValueHydrator::object($data['web'] ?? null, [DocumentFormat::class], false);
        $this->pdf = \Inttegro\ValueHydrator::object($data['pdf'] ?? null, [DocumentFormat::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
