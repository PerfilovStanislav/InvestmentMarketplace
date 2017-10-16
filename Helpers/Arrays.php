<?php

namespace Helpers {

	class Arrays {
        private $arr;

        function __construct(array $arr) {
            $this->arr = $arr;
        }

        public function getArray() {
            return $this->arr;
        }

		public final static function joinForInsert(array $arr) {
			if (empty($arr) || count($arr) < 1) return null;

			$str = implode(',', $arr);
			if ($str === '') return null;
			return '{'.$str.'}';
		}

        public function array_column($column_name) {
            $this->arr = array_map(function($element) use($column_name){return $element[$column_name];}, $this->arr);
            return $this;
        }

        public function join() {
            $this->arr = implode(',', $this->arr);
            return $this;
        }
	}

}?>