<?php

namespace Inttegro\ChildrenPolicy;

/** Payment-method choices available to child applications. */
final class PaymentMethodsCapabilities extends \Inttegro\DomainValue
{
    /** Mobile-money choices; PHP type: `PaymentMethodCapabilities|null`; wire field: `mobile_money` (`object`). */
    public readonly ?PaymentMethodCapabilities $mobileMoney;
    /** Bank-account choices; PHP type: `PaymentMethodCapabilities|null`; wire field: `bank_account` (`object`). */
    public readonly ?PaymentMethodCapabilities $bankAccount;
    /** Motito choices; PHP type: `PaymentMethodCapabilities|null`; wire field: `motito` (`object`). */
    public readonly ?PaymentMethodCapabilities $motito;
    /** Card choices; PHP type: `PaymentMethodCapabilities|null`; wire field: `card` (`object`). */
    public readonly ?PaymentMethodCapabilities $card;

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public function __construct(array $data)
    {
        $class = [PaymentMethodCapabilities::class];
        $this->mobileMoney = \Inttegro\ValueHydrator::object($data['mobile_money'] ?? null, $class, true);
        $this->bankAccount = \Inttegro\ValueHydrator::object($data['bank_account'] ?? null, $class, true);
        $this->motito = \Inttegro\ValueHydrator::object($data['motito'] ?? null, $class, true);
        $this->card = \Inttegro\ValueHydrator::object($data['card'] ?? null, $class, true);
    }

    /** @param array<string, mixed> $data Wire object keyed by API field names. */
    public static function fromArray(array $data): static { return new static($data); }
}
