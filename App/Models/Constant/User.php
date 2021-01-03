<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class User implements ConstantInterface {
    use Collection;

    public CONST
        ME     = 1,
        GUEST  = 2,
        SYSTEM = 3;
}
