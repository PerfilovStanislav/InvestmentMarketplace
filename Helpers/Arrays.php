<?php

namespace Helpers {

	class Arrays {
		/*function __construct(array $post) {
			$this->post = $post;
		}*/

		public final static function join(array $arr, $type = null) {
			if (empty($arr) || count($arr) < 1) return null;


			$str = implode(',', $arr);
			if ($str === '') return null;
			return '{'.$str.'}';
		}
	}

}?>