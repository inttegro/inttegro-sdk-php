<?php

namespace Inttegro\Payout;

/** Stable, caller-safe reasons that a payout failed. */
enum FailureReason: string
{
    /** Wire value: `provider_declined`. */
    case ProviderDeclined = 'provider_declined';
    /** Wire value: `delivery_failed`. */
    case DeliveryFailed = 'delivery_failed';
    /** Wire value: `temporarily_unavailable`. */
    case TemporarilyUnavailable = 'temporarily_unavailable';
    /** Wire value: `unknown`. */
    case Unknown = 'unknown';
}
