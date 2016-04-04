<?php

namespace Core {

	use Core\View;

	class Controller {
		public $model;
		public $auth;

		function __construct($className, Database $db, Auth $auth) {
			$modelClass = '\Models\\'.(substr($className, strrpos($className, '\\') + 1));
			$this->model = new $modelClass($db);
			$this->auth = $auth;
		}

		protected function view(array $params) {
			$params['userHead']	= ['Users/HeadAuthorized', ['name' => 'HeLLo ‼']];
			foreach($params as $k => &$v) {
				$v = (new View($v[0], $v[1]))->get();
			}

			echo isset($_POST['ajax']) ? json_encode($params): (new View('Layout', $params))->get();
		}
	}

}?>