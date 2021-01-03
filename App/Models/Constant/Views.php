<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class Views implements ConstantInterface {
    use Collection;

    public CONST
        USER_HEAD           = 'userHead',
        CONTENT             = 'content',
        PROJECT_FILTER      = 'projectFilter',
        CHAT_MESSAGE        = 'chatMessage',
        META                = 'meta',
        GOOGLE_TAG_MANAGER  = 'googleTagManager',
        SIDEBAR_LEFT        = 'sidebar_left',
        FORM_SENT           = 'formSent';
}
