<?php

namespace Inttegro\Payout;

/** Whether a payout contribution remains reserved, completed, or released. */
enum BalanceTransactionStatus: string
{
    /** The contribution remains reserved while the payout is open. Wire value: `reserved`. */
    case Reserved = 'reserved';

    /** The contribution was consumed by a successful payout. Wire value: `completed`. */
    case Completed = 'completed';

    /** The contribution was returned after the payout did not complete. Wire value: `released`. */
    case Released = 'released';
}
