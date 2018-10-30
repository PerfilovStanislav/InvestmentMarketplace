<?php

namespace Helpers {

	use Core\View;

	class Helper
	{
		CONST
			JSON = 'Content-type:application/json',
			E404 = 'HTTP/1.0 404 Not Found',
			E500 = 'HTTP/1.0 500 Internal Server Error',
			GZIP = 'Content-Encoding: gzip';

		final public static function header(... $heads) {
			foreach ($heads as $head) {
				header($head);
			}
		}

		final public static function json(array $arr) {
			self::header(self::JSON);
			return self::gzip(json_encode($arr));
		}

		final public static function alert(array $arr) {
			return !self::json(['alert' => ['danger' => $arr]]);
		}

		final public static function error(array $arr, string $scope = 'content') {
			return !self::json(['error' => [$scope => $arr]]);
		}

		final public static function view(array $arr) {
			foreach($arr['c'] as $k => $v) {
				$arr['c'][$k] = (new View($v[0], $v[1]))->get();
			}
			return $arr;
		}

		final public static function jsonv(array $arr) {
			return self::json(self::view($arr));
		}

		final public static function fieldError(string $field, string $key, string $scope= 'content') {
			return self::error(['fields' => [$field => Locale::get($key)]], $scope);
		}

		final public static function gzip(string $output) {
			if (mb_strlen($output) > 1024) {
				$encoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';

				foreach (['deflate', 'gzip', 'x-gzip'] as $v) {
					if (strpos($encoding, $v) !== false) {
						self::header(self::GZIP);
						echo gzencode($output, 2, FORCE_GZIP);
						return !0 & die();
					}
				}
			}

			echo $output;
			return !1 & die();
		}
	}
}
