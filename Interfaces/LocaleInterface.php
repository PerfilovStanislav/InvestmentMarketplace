<?php

namespace Interfaces;

interface LocaleInterface
{
	public static function getLocale():array;
	public static function getPeriodName(int $i, int $k):string;
}
