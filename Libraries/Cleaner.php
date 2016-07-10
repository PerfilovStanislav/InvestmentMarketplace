<?php

namespace Libraries {

	class Cleaner {
		CONST TEXT = '/[^a-zа-я0-9ё \-]/iu';
		CONST EN = '/[^a-z0-9]/iu';
		CONST EMAIL = '/[^a-z0-9\-_.@]/i';
		CONST NUM = '/[^0-9]/i';
		CONST HASH = '/[^a-z0-9\/\.]/i';
		CONST URI = '/[^a-z0-9-_\/]/i';

		public final static function replace($regex, $str) {
			return preg_replace($regex, '', $str);
		}

		/*public final static function issetKeys(array $array, array $needle) {
			return count(array_intersect(array_keys($array), $needle)) === count($needle);
		}*/

	}

}?>