<?php

namespace Models\Constant {

    use Interfaces\ConstantInterface;
    use Traits\Collection;

    class TelegramParseMode implements ConstantInterface {
        use Collection;

        CONST
            MARKDOWN = 'Markdown',
            HTML     = 'HTML';
    }
}
