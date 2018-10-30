<?php

namespace Controllers {

	use Core\{
		Auth, Router
	};
	use Controllers\Hyip;
	use \Models\Users as Model;
	use \Helpers\{Validator, Helper, Locale};

	class Users extends Layout {
		private $model;
		function __construct() {
			parent::__construct();
            $this->model = new Model();
		}

        final public function login (array $page) {
            $this->view(['content' 	=> ['Users/Login', []]]);
        }

        final public function logout() {
            if (Auth::getInstance()->logout()) {
				$url = parse_url($_SERVER['HTTP_REFERER']??'');
				$return['f']['document'] = [
					'allClear',
					'reSend' => ['/Users/getUserInfo', $url['path']],
				];
			}
			else {
				$return['f']['document'] = ['reload'];
			}

			return Helper::json($return);
        }

        final public function getUserInfo() {
			// TODO
			// TODO
			// TODO
			// TODO
			$return['c']['userHead'] = Users::getUserHead();
			$return['f']['document'] = [
				'setStorage' => ['user' => Auth::getUserInfo()],
				'UserAuthorization',
			];
			return Helper::jsonv($return);
		}

		final public function registration() {
		    $view = Auth::isAuthorized() ? 'Registered' : 'Registration';

            $return['c']['content'] = ['Users/'.$view, []];
            $return['f']['content'] = ['UserRegistration'];

            return IS_AJAX ? Helper::jsonv($return) : $this->layout($return);
		}

		final public function add() {
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

        final public function authorize() {
            if ($_POST['login']??!1 && $_POST['password']??!1) {
                $this->post->checkAll('password', 8, 64)->checkErrors();
                if (strpos($_POST['login'], '@') > 0) $this->post->checkAll('login', 8, 64, Validator::EMAIL)->checkErrors();
                else $this->post->checkAll('login', 4, 32, Validator::EN)->checkErrors();

                Auth::getInstance()->authorize($this->post->login, $this->post->password);
				$url = parse_url($_SERVER['HTTP_REFERER']??'');
				$return['c']['userHead'] = Users::getUserHead();
				$return['f']['document'] = [
					'reSend' => [$url['path']],
					'UserAuthorization',
					'setStorage' => ['user' => Auth::getUserInfo()]
				];

				return Helper::jsonv($return);
            }
            return false;
        }

        final public static function getUserHead():array {
			$available_langs = Locale::getAvailableLanguages();
			$head_path = 'Users/Head/'.(Auth::isAuthorized()?'':'Not').'Authorized';
			$data = array_merge(Auth::getUserInfo(), ['langs' => $available_langs]);
			return [$head_path, $data];
		}
	}
}