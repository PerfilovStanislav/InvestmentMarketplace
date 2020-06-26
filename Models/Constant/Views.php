<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class Views implements ConstantInterface {
    use Collection;

    public CONST
        USER_HEAD           = 'userHead',
        CONTENT             = 'content',
        PROJECT_FILTER      = 'projectFilter',
        CHAT_MESSAGE        = 'chatMessage',
        META                = 'meta',
        GOOGLE_TAG_MANAGER  = 'googleTagManager',
//        YANDEX_METRICA      = 'yandexMetrica',
//        GOOGLE_ANALITIC     = 'googleAnalitic',
        SIDEBAR_LEFT        = 'sidebar_left',
        FORM_SENT           = 'formSent';
}
