<?php

namespace Core {

    use Helpers\{
        Locale, Validator, Helper
    };
    use Models\Main;

    class Controller {
        protected   $post;

		protected function __construct() {
		    $this->post = new Validator($_POST ?? []);
		}

		protected final function view(array $params) {
			if (!IS_AJAX) {
                $this->loadHead($params);
			}
			foreach($params as &$v) {
				$v = (new View($v[0], $v[1]))->get();
			}

			if (IS_AJAX) Helper::json($params);
            else echo (new View('Layout', $params))->get();
		}

		/*final private function loadHead(array &$params) {
            $available_langs = Locale::getAvailableLanguages();
            if (Auth::isAuthorized()) 	$params['userHead']	= ['Users/Head/Authorized', array_merge(Auth::getUserInfo(), ['langs' => $available_langs])];
            else 						$params['userHead']	= ['Users/Head/NotAuthorized', $available_langs];
        }*/
	}

}?>