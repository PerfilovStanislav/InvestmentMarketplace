<?php

namespace Interfaces;

interface ConstantInterface
{
    public static function getCollection(): array;

    public static function getConstNames(): array;

    public static function getValues(): array;

    public static function getValue(string $key);

    public static function getConstNameLower($val): string ;
}
