<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class Views implements ConstantInterface {
    use Collection;

    public CONST
        USER_HEAD       = 'userHead',
        CONTENT         = 'content',
        PROJECT_FILTER  = 'projectFilter',
        CHAT_MESSAGE    = 'chatMessage',
        META            = 'meta',
        SIDEBAR_LEFT    = 'sidebar_left';
}
