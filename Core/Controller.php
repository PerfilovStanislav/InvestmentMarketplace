<?php

namespace Core {

	use Core\View;
    use Helpers\{Validator, Helper};

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