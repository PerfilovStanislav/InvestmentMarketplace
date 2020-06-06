<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class PaymentType implements ConstantInterface {
    use Collection;

    public const
        MANUAL    = 1,
        INSTANT   = 2,
        AUTOMATIC = 3;
}
