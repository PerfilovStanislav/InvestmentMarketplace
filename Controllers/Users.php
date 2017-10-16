<?php

namespace Controllers {
	use Core\{Controller,Database,Auth};
	use \Models\Users as Model;
	use \Helpers\{Validator, Helper};

	class Users extends Controller{
		private $model;
		function __construct(Database $db, Auth $auth) {
			parent::__construct($db, $auth);
			$this->model = new Model($db);
		}

        public function login(array $page) {
            $this->view(['content' 	=> ['Users/Login', []]]);
        }

        public function logout(array $page) {
            $this->auth->logout();
        }

		public function registration(array $page) {
			$this->view(['content' 	=> ['Users/Registration', []]]);
		}

		public function add() {
			$this->post
				->checkAll('login', 4, 32, Validator::EN)
				->checkAll('name', 4, 64, Validator::EN)
				->checkAll('email', 8, 64, Validator::EMAIL)
				->checkAll('password', 8, 64);

			if (!$this->post->getErrors()) {
                Helper::show_json($this->model->addUser($this->post));
			}
			else Helper::show_json(['error' => ['fields' => $this->post->getErrors()]]);
		}

        public function authorize() {
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $this->post->checkAll('password', 8, 64);
                if (strpos($_POST['login'], '@') > 0) $this->post->checkAll('login', 8, 64, Validator::EMAIL);
                else 								  $this->post->checkAll('login', 4, 32, Validator::EN);

                if ($this->post->getErrors()) {
                    Helper::show_json(['error' => ['fields' => $this->post->getErrors()]]);
                    return;
                }

                Helper::show_json($this->auth->authorize($_POST['login'], $_POST['password']));
            }
        }
	}
}