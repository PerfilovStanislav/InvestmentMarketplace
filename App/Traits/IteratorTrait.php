<?php

namespace App\Traits;

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
        return $key !== NULL && $key !== FALSE;
    }

    public function count() {
        return count($this->data);
    }
}