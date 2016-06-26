<?php

namespace Controllers {
	use Core\Controller;
	use Core\Database;
	use Core\View;
	use Core\Auth;
	use Core\Router;

	class Users extends Controller{
		private $model;
		function __construct(Database $db, Auth $auth) {
			parent::__construct(__CLASS__, $db, $auth);
			$this->model = new \Models\Users($db);
		}

		public function registration(array $page) {
			$this->view(['content' 	=> ['Users/Registration', []]]);
		}

		public function add() {
			$this->model->addUser($_POST);
		}
		
		public function authorize() {
			if (isset($_POST['login']) && isset($_POST['password'])) {
				echo $this->auth->authorize($_POST['login'], $_POST['password']);
			}
		}

		public function logout() {
			$this->auth->logout();
		}
	}

}?>