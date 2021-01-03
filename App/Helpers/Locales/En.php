<?php

namespace App\Helpers\Locales;

class En extends AbstractLanguage {

    public function getPeriodName(int $i, int $k): string {
        return ['minute', 'hour', 'day', 'week', 'month', 'year'][$i-1].($k>1?'s':'');
    }
}

