<?php

namespace App\Helpers\Locales;

interface LocaleInterface
{
    public function getPeriodName(int $i, int $k): string;
}
