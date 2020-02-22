<?php

namespace Interfaces;

interface EntityInterface
{
    function fromArray(array $data);

    function __get($key);

    function __set($name, $value);

    function __unset($name);

//    function excludeDefault();

    static function getDefaults() : array;

    static function getPropertyKeys(): array;
}
