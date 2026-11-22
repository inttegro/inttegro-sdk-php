<?php

namespace Inttegro\Order;

/** Receipt issued for a paid order payment. */
final class Receipt extends \Inttegro\DomainValue
{
    /**
     * Merchant-provided receipt number.
     *
     * Optional response field. PHP type: `string|null`; wire field: `number` (`string`).
     *
     * @var string|null
     */
    public readonly ?string $number;

    /**
     * Hosted receipt representations.
     *
     * Required response field. PHP type: `ReceiptFormat`; wire field: `format` (`object`).
     *
     * @var ReceiptFormat
     */
    public readonly ReceiptFormat $format;

    /**
     * Receipt delivery history.
     *
     * Optional response field. PHP type: `DocumentDeliverySummary|null`; wire field:
     * `delivery_summary` (`object`).
     *
     * @var DocumentDeliverySummary|null
     */
    public readonly ?DocumentDeliverySummary $deliverySummary;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, true);
        $this->format = \Inttegro\ValueHydrator::object($data['format'] ?? null, [ReceiptFormat::class], false);
        $this->deliverySummary = \Inttegro\ValueHydrator::object(
            $data['delivery_summary'] ?? null,
            [DocumentDeliverySummary::class],
            true,
        );
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
