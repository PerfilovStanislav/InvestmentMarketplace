<?php

namespace Controllers {
	use Core\{Auth};
	use Controllers\Hyip;
	use \Models\Users as Model;
	use \Helpers\{Validator, Helper, Locale};

	class Users extends Layout {
		private $model;
		function __construct() {
			parent::__construct();
            $this->model = new Model();
		}

        public function login(array $page) {
            $this->view(['content' 	=> ['Users/Login', []]]);
        }

        public function logout(array $page) {
            Auth::getInstance()->logout();
        }

		public function registration() {
		    $view = Auth::isAuthorized() ? 'Registered' : 'Registration';

            $return['c']['content'] = ['Users/'.$view, []];
            $return['f']['content'] = ['UserRegistration'];

            return IS_AJAX ? Helper::json($return) : $this->layout($return);
		}

		public function add() {
			$this->post
				->checkAll('login'	 , 4, 32, Validator::EN)
				->checkAll('name'	 , 4, 64, Validator::EN)
				->checkAll('email'	 , 8, 64, Validator::EMAIL)
				->checkAll('password', 8, 64)->checkErrors();

            $res = $this->model->addUser($this->post);
            if ($res['success'] ?? false) {
				return (new Hyip())->show([]);
			}
			else return Helper::json($res);
		}

        public function authorize(array $params = []) {
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $this->post->checkAll('password', 8, 64)->checkErrors();
                if (strpos($_POST['login'], '@') > 0) $this->post->checkAll('login', 8, 64, Validator::EMAIL)->checkErrors();
                else 								  $this->post->checkAll('login', 4, 32, Validator::EN)->checkErrors();

                Helper::json(Auth::getInstance()->authorize($_POST['login'], $_POST['password']));
            }
        }
	}
}