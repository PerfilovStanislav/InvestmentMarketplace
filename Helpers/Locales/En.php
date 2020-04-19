<?php

namespace Helpers\Locales;

class En extends AbstractLanguage {

    public static int $id = 219;

    public function getPeriodName(int $i, int $k): string {
        return ['minute', 'hour', 'day', 'week', 'month', 'year'][$i-1].($k>1?'s':'');
    }
}

