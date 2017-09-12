<?php

namespace Core {

	use Core\View;
    use Helpers\{
        Locale, Validator, Helper
    };

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
                $lang = ['En', 'Ru', 'De', 'Fr', 'Gg'];
                $rrr = array_splice($lang, 2, 2);
                echo '<pre>'; print_r($rrr); die();
			    var_dump(Locale::getLanguage()); die();
				if (Auth::isAuthorized()) 	$params['userHead']	= ['Users/Head/Authorized', Auth::getUserInfo()];
				else 						$params['userHead']	= ['Users/Head/NotAuthorized', []];
			}
			foreach($params as $k => &$v) {
				$v = (new View($v[0], $v[1]))->get();
			}

			if (IS_AJAX) Helper::show_json($params);
            else echo (new View('Layout', $params))->get();
		}
	}

}?>