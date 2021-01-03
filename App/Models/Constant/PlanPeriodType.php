<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class PlanPeriodType implements ConstantInterface {
    use Collection;

    public CONST
        MINUTE = 1,
        HOUR   = 2,
        DAY    = 3,
        WEEK   = 4,
        MONTH  = 5,
        YEAR   = 6;
}
