<?php

namespace Inttegro\Payout;

/**
 * Current payout lifecycle state.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum Status: string
{
    /**
     * Selects the `initialized` API value for payout status.
     *
     * Wire value: `initialized`.
     */
    case Initialized = 'initialized';

    /**
     * Selects the `scheduled` API value for payout status.
     *
     * Wire value: `scheduled`.
     */
    case Scheduled = 'scheduled';

    /**
     * Processing is currently in progress.
     *
     * Wire value: `processing`.
     */
    case Processing = 'processing';

    /**
     * Selects the `executing` API value for payout status.
     *
     * Wire value: `executing`.
     */
    case Executing = 'executing';

    /**
     * The operation completed successfully.
     *
     * Wire value: `succeeded`.
     */
    case Succeeded = 'succeeded';

    /**
     * The payout could not be completed.
     *
     * Wire value: `failed`.
     */
    case Failed = 'failed';

    /**
     * The operation was canceled before successful completion.
     *
     * Wire value: `canceled`.
     */
    case Canceled = 'canceled';
}
