<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class PaymentType implements ConstantInterface {
    use Collection;

    public const
        MANUAL    = 1,
        INSTANT   = 2,
        AUTOMATIC = 3;
}
