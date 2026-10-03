<?php

namespace Inttegro\PurchaseIntent;

/** Presentation settings for the hosted Buy page. */
final class BuyPagePresentation extends \Inttegro\DomainValue
{
    /** Hosted Buy-page text overrides. Wire field: `text`. */
    public readonly ?BuyPageText $text;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->text = \Inttegro\ValueHydrator::object($data['text'] ?? null, [BuyPageText::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
