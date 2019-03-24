<?php

namespace Controllers {

	use Core\{
		Auth, Controller
	};
	use Models\Users as Model;
	use Helpers\{Validator, Helper, Locale};
    use Views\{
        Users\Head\Authorized as ViewAuthorized,
        Users\Head\NotAuthorized as ViewNotAuthorized
    };

	class Users extends Controller {
		private $model;
		function __construct() {
			parent::__construct();
            $this->model = new Model();
		}

        final public function login (array $page) {
            $this->view(['content' 	=> ['Users/Login', []]]);
        }

        final public function logout() {
			Auth::getInstance()->logout();
			$this->reloadPage();
        }

        final private function reloadPage() {
			$url = parse_url($_SERVER['HTTP_REFERER']??'');
			Helper::$r['f']['document']['addToAjaxQueue'] = [
				'/Users/head',
//				'/Hyip/leftside',
				$url['path']
			];
		}

		final public function authorize() {
			if ($_POST['login']??!1 && $_POST['password']??!1) {
				$this->post->checkAll('password', 8, 64)->exitWithErrors();
				if (strpos($_POST['login'], '@') > 0) $this->post->checkAll('login', 8, 64, Validator::EMAIL)->exitWithErrors();
				else $this->post->checkAll('login', 4, 32, Validator::EN)->exitWithErrors();

				Auth::getInstance()->authorize($this->post->login, $this->post->password);
				$this->reloadPage();
			}
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
				->checkAll('password', 8, 64)->exitWithErrors();

            $res = $this->model->addUser($this->post);
            if ($res['success'] ?? false) {
				return (new Hyip())->show([]);
			}
			else return Helper::json($res);
		}

        final public static function setUserHead() {
			Helper::$r['c']['userHead'] = [
                Auth::isAuthorized() ? ViewAuthorized::class : ViewNotAuthorized::class,
				array_merge(
					Auth::getUserInfo(),
					[
						'activeLang' => Locale::getLanguage(),
						'availableLangs' => Locale::getAvailableLanguages(),
						'photoThumb' => self::getUserPhoto(true)
					])
			];

			Helper::$r['f']['document']['setStorage']['user'] = Auth::getUserInfo();
			Helper::$r['f']['document'][] = 'UserAuthorization';
		}

		final public function head() {
			return self::setUserHead();
		}

		final private static function getUserPhoto(bool $thumb = false) : string {
			// @TODO
			if ($thumb || true) {
				$info = Auth::getUserInfo();
				return sprintf('/assets/img/avatars2/%s.webp', (($info['id'] ?? $info['session_id'] ?? 1)-1)%30+1);
			}
		}

		/*final public function getUsers(array $ids) {
			$users = $this->model->getUsersByIds($ids);

			$arrayHelper = new Arrays();
			return $arrayHelper->setArray($chats)->groupBy(['project_id', 'id'])->getArray();
		}*/

		final public function changeLanguage(array $params = []) {
			if ($langId = ((Locale::getAvailableLanguages()[$params['lang'] ?? null] ?? null)['id'] ?? null)) {
				if (Auth::isAuthorized()) {
					$this->model->db->update('user_params', [':lang_id' => $langId], 'user_id = ' . Auth::getUserInfo()
						['id']);
				}
				else {
					$_SESSION['lang'] = $params['lang'];
				}
			}
			$this->reloadPage();
		}
	}
}