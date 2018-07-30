<?php

namespace Helpers {

	class Arrays {
        private $arr;

        final function __construct(array $arr = []) {
            $this->arr = $arr;
        }

        public final function setArray(array $arr) {
            $this->arr = $arr;
            return $this;
        }

        public final function getArray() {
            return $this->arr;
        }

		public final static function joinForInsert(array $arr) {
			if (empty($arr) || count($arr) < 1) return null;

			$str = implode(',', $arr);
			if ($str === '') return null;
			return '{'.$str.'}';
		}

        public final function arrayColumn($column_name) {
            $this->arr = array_map(function($element) use($column_name){return $element[$column_name];}, $this->arr);
            return $this;
        }

        public final function join() {
            return implode(',', $this->arr);
        }

        public final function groupBy($cols) {
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

        public final function toArray($keys) {
            foreach ($this->arr as &$arr) {
                foreach ($keys as $key) {
                    $arr[$key] = json_decode($arr[$key]);
                }
            }
            return $this;
        }
	}

}?>