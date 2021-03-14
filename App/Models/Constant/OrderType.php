<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class OrderType implements ConstantInterface {
    use Collection;

    public CONST
        BANNER = 1;
}
