<?php

namespace Controllers {
	use Core\{Controller,Database,Auth};
	use \Models\Users as Model;
	use \Helpers\Validator;

	class Users extends Controller{
		private $model;
		function __construct(Database $db, Auth $auth) {
			parent::__construct($db, $auth);
			$this->model = new Model($db);
		}

		public function registration(array $page) {
			$this->view(['content' 	=> ['Users/Registration', []]]);
		}

		public function add() {
			$post = (new Validator($_POST))
				->checkAll('login', 4, 32, Validator::EN)
				->checkAll('name', 4, 64, Validator::TEXT)
				->checkAll('email', 8, 64, Validator::EMAIL)
				->checkAll('password', 8, 64);

			if (!$post->getErrors()) {
				echo json_encode($this->model->addUser($post->getData()));
			}
			else echo json_encode(['errors' => ['fields' => $post->getErrors()]]);
		}
		
		public function authorize() {
			if (isset($_POST['login']) && isset($_POST['password'])) {
				echo $this->auth->authorize($_POST['login'], $_POST['password']);
			}
		}

		public function logout() {
			Auth::logout();
//			$this->auth->logout();
		}
	}

}?>