<?php

namespace Inttegro\Price;

/** Definition carried by a catalog price. */
enum Type: string
{
    case FixedAmount = 'fixed_amount';
    case CustomerSelectedAmount = 'customer_selected_amount';
}
