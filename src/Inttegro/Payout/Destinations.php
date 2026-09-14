<?php

namespace Inttegro\Payout;

/**
 * Supported currency-to-financial-account payout assignments.
 *
 * The API currently supports an explicit Ghana cedi destination. Construct the value with
 * `new Destinations(['ghs' => 'fa_...'])`; use an empty string to remove that assignment.
 */
final class Destinations extends \Inttegro\DomainValue
{
    /**
     * Financial account that receives Ghana cedi payouts.
     *
     * Optional field. PHP type: `string|null`; wire field: `ghs` (`string`).
     * Supply an empty string when removing the assignment.
     *
     * @var string|null
     */
    public readonly ?string $ghs;

    /** @param array{ghs?: string|null} $data */
    public function __construct(array $data)
    {
        $this->ghs = \Inttegro\ValueHydrator::string($data['ghs'] ?? null, true);
    }

    /** @param array{ghs?: string|null} $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
