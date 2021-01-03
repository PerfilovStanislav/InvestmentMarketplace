<?php

namespace App\Interfaces;

interface ConstantInterface
{
    public static function getCollection();

    public static function getConstNames();

    public static function getValues();

    public static function getValue(string $key);

    public static function getConstNameLower($val);
}
