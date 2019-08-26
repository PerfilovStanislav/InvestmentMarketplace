<?php

namespace Traits;

trait IteratorTrait {
    public function rewind() {
        reset($this->data);
    }

    public function current() {
        $var = current($this->data);
        return $var;
    }

    public function key() {
        $var = key($this->data);
        return $var;
    }

    public function next() {
        $var = next($this->data);
        return $var;
    }

    public function valid() {
        $key = key($this->data);
        $var = ($key !== NULL && $key !== FALSE);
        return $var;
    }

    public function count() {
        return empty($this->data) ? 0 : count($this->data);
    }
}