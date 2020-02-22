<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class TelegramParseMode implements ConstantInterface {
    use Collection;

    public CONST
        MARKDOWN = 'Markdown',
        HTML     = 'HTML';
}
