<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class UserStatus implements ConstantInterface {
    use Collection;

    public CONST
          FAKE          = 1
        , USER          = 2
        , ADMIN         = 3
    ;
}
