<?php

namespace Interfaces;

interface LocaleInterface
{
    static function getLocale(): array;
    static function getPeriodName(int $i, int $k): string;
}
