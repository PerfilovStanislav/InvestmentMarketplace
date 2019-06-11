<?php

namespace Params;

/**
 * Class AbstractParams
 * @package Params
 */
abstract class AbstractParams {
    protected $data;
    /** @var AbstractParams $defaults */
    public static $defaults = null;

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    final public function __get($name) {
        return $this->data[$name] ?? null;
    }

    final public function __set($name, $value) : self {
        $this->data[$name] = $value;
        return $this;
    }

    final public function get() : array {
        return $this->data;
    }

    final public function set(array $data) : self {
        $this->data = $data;
        return $this;
    }

    final public function __unset($name) {
        unset($this->data[$name]);
    }

    final public function excludeDefault() {
        foreach ($this->get() as $key => $value) {
            if (static::$defaults->$key == $value) unset($this->$key);
        }
        return $this;
    }

}