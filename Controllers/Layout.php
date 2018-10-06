<?php

namespace Controllers {

	use Core\{
		Auth, Controller, View
	};
	use Helpers\Helper;
	use Helpers\Locale;

	class Layout extends Controller{

		protected final function layout($return) {
			$available_langs = Locale::getAvailableLanguages();
			$head_path = 'Users/Head/'.(Auth::isAuthorized()?'':'Not').'Authorized';
			$data = array_merge(Auth::getUserInfo(), ['langs' => $available_langs]);
			$return['c']['userHead'] = [$head_path, $data];

			$return = Helper::view($return);
			$return['f']['document'] = array_merge($return['f']['document']??[], ['setStorage' => ['user' => Auth::getUserInfo()], 'UserAuthorization']);
			uksort($return['f'], function($a,$b) {
				return $a == 'document' ? -1 : 1;
			});

			if ($return['f']??!1) {
				$return['c']['f'] = $return['f'];
				unset ($return['f']);
			}

			echo (new View('Layout', $return['c']))->get();
		}

	}

}