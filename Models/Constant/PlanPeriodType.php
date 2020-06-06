<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

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
