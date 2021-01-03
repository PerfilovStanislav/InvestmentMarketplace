<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class DomElements implements ConstantInterface {
    use Collection;

    public CONST
        AUTHORIZATION_USER_FORM = 'authorizationuser_form',
        ADD_USER_FORM           = 'add_user_form';
}
