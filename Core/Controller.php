<?php

namespace Core {

	use Core\View;

	class Controller {
		protected $auth;
		public $isAjax;
		private $db;

		function __construct(Database $db, Auth $auth) {
			$this->auth = $auth;
			$this->isAjax = isset($_POST['ajax']) && $_POST['ajax'] == 1;
			$this->db = $db;
		}

		protected final function view(array $params) {
			if (!$this->isAjax) {
				if (Auth::isAuthorized()) 	$params['userHead']	= ['Users/Head/Authorized', Auth::getUserInfo()];
				else 						$params['userHead']	= ['Users/Head/NotAuthorized', []];
			}
			foreach($params as $k => &$v) {
				$v = (new View($v[0], $v[1]))->get();
			}

			echo $this->isAjax /*isset($_POST['ajax'])*/ ? json_encode($params): (new View('Layout', $params))->get();
		}
	}

}?>