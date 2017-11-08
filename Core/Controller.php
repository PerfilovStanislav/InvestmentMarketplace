<?php

namespace Core {

    use Helpers\{
        Locale, Validator, Helper
    };
    use Models\Main;

    class Controller {
		protected   $auth;
		public      $isAjax;
        protected   $db;
        protected   $post;

		function __construct(Database $db, Auth $auth) {
		    $this->post = new Validator($_POST ?? []);
			$this->auth = $auth;
			$this->db = $db;
		}

		protected final function view(array $params) {
			if (!IS_AJAX) {
                $this->loadHead($params);
			}
			foreach($params as &$v) {
				$v = (new View($v[0], $v[1]))->get();
			}

			if (IS_AJAX) Helper::show_json($params);
            else echo (new View('Layout', $params))->get();
		}

		private final function loadHead(array &$params) {
            $available_langs = Locale::getAvailableLanguages();
            if (Auth::isAuthorized()) 	$params['userHead']	= ['Users/Head/Authorized', array_merge(Auth::getUserInfo(), ['langs' => $available_langs])];
            else 						$params['userHead']	= ['Users/Head/NotAuthorized', $available_langs];
        }
	}

}?>