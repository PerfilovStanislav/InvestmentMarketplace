<?php

namespace Helpers {

	class Arrays {
        private $arr;

        final function __construct(array $arr = []) {
            $this->arr = $arr;
        }

        final public function setArray(array $arr) {
            $this->arr = $arr;
            return $this;
        }

        final public function getArray() {
            return $this->arr;
        }

		final public static function joinForInsert(array $arr) {
			if (empty($arr) || count($arr) < 1) return null;

			$str = implode(',', $arr);
			if ($str === '') return null;
			return '{'.$str.'}';
		}

        final public function arrayColumn($column_name) {
            $this->arr = array_map(function($element) use($column_name){return $element[$column_name];}, $this->arr);
            return $this;
        }

        final public function join() {
            return implode(',', $this->arr);
        }

        final public function groupBy($cols) {
            $r = [];
            foreach ($this->arr as $a) {
                $t = &$r;
                foreach ($cols as $col) {
                    $t = &$t[$a[$col]];
                }
                $t = array_filter($a, function($k) use($cols) {return !in_array($k, $cols);}, ARRAY_FILTER_USE_KEY );
            }
            $this->arr = $r;
            return $this;
        }

        final public function toArray($keys) {
            foreach ($this->arr as &$arr) {
                foreach ($keys as $key) {
                    $arr[$key] = json_decode($arr[$key]);
                }
            }
            return $this;
        }
	}

}?>