<?php

namespace Helpers\Locales;

interface LocaleInterface
{
    public function getPeriodName(int $i, int $k): string;
}
