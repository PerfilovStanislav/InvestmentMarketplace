<?php

namespace Libraries {

	class PregReplace {
		CONST TYPES = [
			'text' => '/[^a-zа-я0-9ё \-]/iu',
			'en' => '/[^a-z0-9]/iu',
			'email' => '/[^a-z0-9\-_.@]/i',
			'num' => '/[^0-9]/i',
			'hash' => '/[^a-z0-9\/\.]/i',
			'uri' => '/[^a-z0-9-_\/]/i'
		];

		public final static function replace($const, $str) {
			return preg_replace(self::TYPES[$const], '', $str);
		}

	}

}?>