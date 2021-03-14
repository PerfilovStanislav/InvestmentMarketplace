<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class OrderStatus implements ConstantInterface {
    use Collection;

    public CONST
        CREATED = 1,
        SUCCESS = 2,
        FAIL    = 3
    ;
}
