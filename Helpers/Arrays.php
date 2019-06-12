<?php

namespace Helpers {

	class Arrays {
        private $arr;

        final function __construct(array $arr = []) {
            $this->arr = $arr;
        }

        final public function setArray(array $arr):self {
            $this->arr = $arr;
            return $this;
        }

        final public function getArray():array {
            return $this->arr;
        }

		final public static function joinForInsert(array $arr):string {
			if (empty($arr) || count($arr) < 1) return null;

			$str = implode(',', $arr);
			if ($str === '') return null;
			return '{'.$str.'}';
		}

        final public function join() {
            return implode(',', $this->arr);
        }

        final public function groupBy(array $cols):self {
            $r = [];
            foreach ($this->arr as $a) {
                $t = &$r;
                foreach ($cols as $col) {
                    $t = &$t[$a[$col]];
                }
                $t = array_filter($a, function($k) use($cols):bool {
                		return !in_array($k, $cols);
                	},ARRAY_FILTER_USE_KEY);
            }
            $this->arr = $r;
            return $this;
        }

        final public function toArray(array $keys):self {
            foreach ($this->arr as &$arr) {
                foreach ($keys as $key) {
                    $arr[$key] = json_decode($arr[$key]);
                }
            }
            return $this;
        }

        final public function getUnique(string $column_name) {
        	$r = [];
			foreach ($this->arr as $arr) {
				foreach ($arr as $val) {
					if ($tmp = $val[$column_name])
						$r[$tmp] = $tmp;
				}
			}
			$this->arr = array_keys($r);
			return $this;
		}

		final public static function toUri(array $params) : string {
            $array = [];
            foreach ($params as $key => $value) {
                $array[] = "$key/$value";
            }
            return implode('/', $array);
        }

        final public static function reNumber(array &$data) {
            $row = 0;
            foreach ($data as $key => &$val) {
                $val['rowNumber'] = ++$row;
            }
        }
	}
}
