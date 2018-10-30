<?php

namespace Controllers {

	use Core\{
		Auth, Controller, View
	};
	use Helpers\Helper;

	class Layout extends Controller{

		protected final function layout(array $return) {
			$return['c']['userHead'] = Users::getUserHead();
			$return = Helper::view($return);
			$return['f']['document'] = array_merge($return['f']['document']??[], ['setStorage' => ['user' => Auth::getUserInfo()], 'UserAuthorization']);
			uksort($return['f'], function($a,$b) {
				return $a == 'document' ? -1 : 1;
			});

			if ($return['f']??!1) {
				$return['c']['f'] = $return['f'];
				unset ($return['f']);
			}

			return Helper::gzip((new View('Layout', $return['c']))->get());
		}

	}

}