<?php

namespace Controllers {

	use Core\{
		Auth, Controller
	};
	use Models\Users as Model;
	use Helpers\{Validator, Output, Locale};
    use Views\{
        Users\Head\Authorized,
        Users\Head\NotAuthorized,
        Users\Login,
        Users\Registered,
        Users\Registration,
        SideLeft
    };

	class Users extends Controller {
		private $model;
		function __construct() {
			parent::__construct();
            $this->model = new Model();
		}

        final public function login () {
            $this->view(['content' 	=> [Login::class, []]]);
        }

        final public function logout() {
			Auth::getInstance()->logout();
			$this->reloadPage();
        }

        final private function reloadPage() {
			$url = parse_url($_SERVER['HTTP_REFERER']??'');
			Output::$r['f']['document']['addToAjaxQueue'] = [
				'/Users/head',
				'/Users/left',
//				'/Investment/leftside',
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
            Output::$r['c']['content'] = [Auth::isAuthorized() ? Registered::class : Registration::class, []];
            Output::$r['f']['content'] = ['UserRegistration'];
		}

		final public function add() {
			$this->post
				->checkAll('login'	 , 4, 32, Validator::EN)
				->checkAll('name'	 , 4, 64, Validator::EN)
				->checkAll('email'	 , 8, 64, Validator::EMAIL)
				->checkAll('password', 8, 64)->exitWithErrors();

            $res = $this->model->addUser($this->post);
            if ($res['success'] ?? false) {
                // @TODO
				return (new Investment())->show([]);
			}
			else return Output::json($res);
		}

        final public static function setUserHead() {
			Output::$r['c']['userHead'] = [
                Auth::isAuthorized() ? Authorized::class : NotAuthorized::class,
				array_merge(
					Auth::getUserInfo(),
					[
						'activeLang' => Locale::getLanguage(),
						'availableLangs' => Locale::getAvailableLanguages(),
						'photoThumb' => self::getUserPhoto(true)
					])
			];

			Output::$r['f']['document']['setStorage']['user'] = Auth::getUserInfo();
			Output::$r['f']['document'][] = 'UserAuthorization';
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
			return '';
		}

        final public function left() {
            return self::setLeftSide();
        }

        final public static function setLeftSide() {
            Output::$r['c']['sidebar_left'] = [
                SideLeft::class,
                []
            ];
        }

		final public function changeLanguage(array $params = []) {
			if ($langId = ((Locale::getAvailableLanguages()[$params['lang'] ?? null] ?? null)['id'] ?? null)) {
				if (Auth::isAuthorized()) {
					$this->model->db->update(
					    'user_params',
                        [':lang_id' => $langId],
                        'user_id = ' . Auth::getUserInfo()['id']
                    );
				}
				else {
					$_SESSION['lang'] = $params['lang'];
				}
			}
			$this->reloadPage();
		}
	}
}