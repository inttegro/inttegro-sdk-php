<?php

namespace Inttegro\PurchaseIntent;

/** Customer-facing presentation settings for a purchase intent. */
final class Presentation extends \Inttegro\DomainValue
{
    /** Hosted Buy-page presentation settings. Wire field: `buy_page`. */
    public readonly ?BuyPagePresentation $buyPage;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->buyPage = \Inttegro\ValueHydrator::object($data['buy_page'] ?? null, [BuyPagePresentation::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
