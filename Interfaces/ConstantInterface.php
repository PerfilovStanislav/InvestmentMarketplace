<?php

namespace Interfaces;

interface ConstantInterface
{
    static function getCollection(): array;

    static function getConstNames(): array;

    static function getValues(): array;

    static function getValue(string $key);

    static function getConstName($key): string ;
}
