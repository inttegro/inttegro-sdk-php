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
     * Optional response field. PHP type: `array<string, mixed>|null`; wire field:
     * `delivery_summary` (`object`).
     *
     * @var array<string, mixed>|null
     */
    public readonly ?array $deliverySummary;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = \Inttegro\ValueHydrator::string($data['number'] ?? null, true);
        $this->format = \Inttegro\ValueHydrator::object($data['format'] ?? null, [ReceiptFormat::class], false);
        $this->deliverySummary = \Inttegro\ValueHydrator::array($data['delivery_summary'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
