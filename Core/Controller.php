<?php

namespace Core {

	use Core\View;

	class Controller {
		public $auth;
		public $isAjax;
		private $db;

		function __construct($className, Database $db, Auth $auth) {
			$this->auth = $auth;
			$this->isAjax = isset($_POST['ajax']) && $_POST['ajax'] == 1;
			$this->db = $db;
		}

		protected final function view(array $params) {
			if (!$this->isAjax) {
				if ($this->auth->isAuthorized()) 	$params['userHead']	= ['Users/Head/Authorized', $this->auth->getUserInfo()];
				else 								$params['userHead']	= ['Users/Head/NotAuthorized', []];
			}
			foreach($params as $k => &$v) {
				$v = (new View($v[0], $v[1]))->get();
			}

			echo isset($_POST['ajax']) ? json_encode($params): (new View('Layout', $params))->get();
		}
	}

}?>