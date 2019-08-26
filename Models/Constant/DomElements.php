<?php

namespace Models\Constant {

    use Interfaces\ConstantInterface;
    use Traits\Collection;

    class DomElements implements ConstantInterface {
        use Collection;

        CONST
            AUTHORIZATION_USER_FORM = 'authorizationuser_form',
            ADDUSER_FORM            = 'adduser_form';
    }
}
