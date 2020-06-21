<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class User implements ConstantInterface {
    use Collection;

    public CONST
        ME     = 1,
        GUEST  = 2,
        SYSTEM = 3;
}
