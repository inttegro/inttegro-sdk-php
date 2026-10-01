<?php

namespace Inttegro\Price;

/** Definition carried by a catalog price. */
enum Type: string
{
    /** Wire value: `fixed_amount`. */
    case FixedAmount = 'fixed_amount';

    /** Wire value: `customer_selected_amount`. */
    case CustomerSelectedAmount = 'customer_selected_amount';
}
