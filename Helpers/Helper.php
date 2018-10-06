<?php

namespace Helpers {

	use Core\View;

	class Helper
	{
		CONST
			JSON = 'Content-type:application/json',
			E404 = 'HTTP/1.0 404 Not Found',
			E500 = 'HTTP/1.0 500 Internal Server Error';

		public final static function header(... $heads) {
			foreach ($heads as $head) {
				header($head);
			}
		}

		public final static function json(array $arr) {
			self::header(self::JSON);
			echo json_encode($arr);
			return !0 & die();
		}

		public final static function error(array $arr) {
			return !self::json(['alert' => ['danger' => $arr]]);
		}

		public final static function view(array $arr) {
			foreach($arr['c'] as $k => $v) {
				$arr['c'][$k] = (new View($v[0], $v[1]))->get();
			}
			return $arr;
		}
	}
}
