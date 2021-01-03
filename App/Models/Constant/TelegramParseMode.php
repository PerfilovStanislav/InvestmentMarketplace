<?php

namespace App\Models\Constant;

use App\Interfaces\ConstantInterface;
use App\Traits\Collection;

class TelegramParseMode implements ConstantInterface {
    use Collection;

    public CONST
        MARKDOWN = 'Markdown',
        HTML     = 'HTML';
}
