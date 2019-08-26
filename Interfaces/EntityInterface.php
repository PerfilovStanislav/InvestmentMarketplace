<?php

namespace Interfaces;

interface EntityInterface
{
    function fromArray(array $data);

    function __get($name);

    function __set($name, $value);

    function __unset($name);

    function get() : array;

    function excludeDefault();

    static function getDefaults();

    function getActual($key);

    static function getPropertyKeys(): array;
}
