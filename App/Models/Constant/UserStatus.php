<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class UserStatus implements ConstantInterface {
    use Collection;

    public CONST
          FAKE          = 1
        , USER          = 2
        , ADMIN         = 3
    ;
}
