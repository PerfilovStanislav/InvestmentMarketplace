<?php

namespace Helpers;

class Scripts {

	final public static function js(array $arr) {
		foreach ($arr as $dir => $files) {
			foreach ($files as $file) {
				$f = $dir.$file.'.js';
				$t = filemtime(ROOT.$f);
				echo '<script src="'.$f.'?'.$t.'"></script>';
			}
		}
	}

	final public static function css(array $arr) {
		foreach ($arr as $dir => $files) {
			foreach ($files as $file) {
				$f = $dir.$file.'.css';
				$t = filemtime(ROOT.$f);
				echo '<link rel="stylesheet" type="text/css" href="'.$f.'?'.$t.'">';
			}
		}
	}
}