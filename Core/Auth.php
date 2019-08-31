<?php

namespace Core {

    use Helpers\{Locale, Output, Validator};
    use Mapping\StaticFilesRouteMapping;
    use Models\Constant\DomElements;
    use Models\Table\ProjectChatMessage;
    use Models\Table\Session;
    use Models\Table\User;
    use Models\Table\UserRemember;
    use Requests\User\AuthorizeRequest;
    use Traits\Instance;
    use Models\AuthModel;

    class Auth {
        use Instance;

		private $db;
		CONST PREFIX = '$2a$08$';

        private static
            $userInfo,
            $sessionStarted = false;

		private function __construct() {
            self::startSession();
			$this->login();
		}

		private function login() {
			$s = &$_SESSION;
			$c = &$_COOKIE;

			if (isset($s['user_id'])) {
				Auth::setUserAuth((new User())->getById($s['user_id']));
				return;
			}
			else if (isset($c['user_id']) && isset($c['hash'])) {
				$user_id = Validator::validate('user_id', $c['user_id'], AbstractEntity::TYPE_INT, [Validator::MIN => 1]);
				$hash 	 = Validator::validate('hash', $c['hash'], AbstractEntity::TYPE_STRING, [Validator::LENGTH => 53, Validator::REGEX => Validator::HASH]);

				$userRemember = (new UserRemember())->getRowFromDbAndFill([
                    'user_id'   => $user_id,
                    'hash'      => $hash,
                    'ip'        => self::get_ip()
                ]);
				if ($userRemember->id) {
					$s['user_id'] = $user_id;
                    setcookie('user_id' , $user_id,	null,'/',DOMAIN,null,false);
                    setcookie('hash'	, $hash,	null,'/',DOMAIN,null,false);
					Auth::setUserAuth((new User())->getById($user_id));
					return;
				}
				else {
                    $this->removeCookies(['hash', 'user_id']);
                }
			}

			AuthModel::getInstance()->is_authorized = false;
			AuthModel::getInstance()->session_id    = self::getSessionId();
		}

		private static function getSessionId() : ?int {
		    if ($session_id = ($_SESSION['session_id'] ?? null)) return $session_id;

		    $session = new Session();
            $session->getRowFromDbAndFill(['uid' => session_id()]);

			if ($session->id) return $session->id;

			if (StaticFilesRouteMapping::get($_SERVER['REQUEST_URI'])) {
			    return null;
            }

            $session->fromArray(['ip' => self::get_ip()]);
            $session->save();

            return $session->id;
		}

		private static function startSession() {
            session_name('uid');
            session_set_cookie_params(1728000, '/', DOMAIN, false, true);
            session_start();
		}

		public function authorize(AuthorizeRequest $request) : bool {
		    if (AuthModel::getInstance()->is_authorized) {
		        Output::addAlertSuccess('Authorized', Locale::get('you_are_authorized'));
                return true;
            }
            elseif (($user = (new User())->getRowFromDbAndFill([$request->authorizeType => $request->login]))->id) {
                if (self::confirmPassword($request->password, $user->password)) {
                    Auth::setUserAuth($user);
                    ProjectChatMessage::getDb()->update(['user_id' => $user->id], ['session_id' => AuthModel::getInstance()->session_id]);
                    $s = &$_SESSION;
                    $s['user_id'] = $user->id;

                    if ($request->remember == 'on') {
                        $userRemember = (new UserRemember())->getRowFromDbAndFill([
                            'user_id' => $user->id,
                            'ip' => self::get_ip()
                        ]);

                        if (!$userRemember->id) {
                            $userRemember->fromArray(['hash' => self::hashPassword(uniqid($user->id.self::get_ip(), true))])->save();
                        }
                        setcookie('user_id', $user->id,null,'/',DOMAIN,null,false);
                        setcookie('hash', $userRemember->hash,null,'/',DOMAIN,null,false);
                    }
                    return true;
                }
                else {
                    Output::addFieldDanger('password', Locale::get('bad_password'), DomElements::AUTHORIZATION_USER_FORM);
                }
            }
            else {
                Output::addFieldDanger('login', Locale::get('no_user'), DomElements::AUTHORIZATION_USER_FORM);
            }
            return false;
		}

		public function logout() : bool {
			if (!AuthModel::getInstance()->is_authorized) return true;

			UserRemember::getDb()->delete([
			    'user_id' => AuthModel::getUserId(),
			    'ip' => self::get_ip(),
            ]);

			$this->removeCookies(['uid', 'hash', 'user_id']);
			session_destroy();
			return true;
		}

		private static function confirmPassword($password, $hash) : bool {
			return crypt($password, self::PREFIX.$hash) === self::PREFIX.$hash;
		}

		public static function hashPassword($password): string {
			$salt = substr(md5(uniqid('St', true)), 0, 22);
			return substr(crypt($password, self::PREFIX . $salt), 7);
		}

        private static function setUserAuth(User $user) {
            $authModel = AuthModel::getInstance();
            $authModel->user          = $user;
            $authModel->is_authorized = true;
            $authModel->session_id    = self::getSessionId();
        }

		private static function get_ip() : ?string
		{
			return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.1';
		}

		private function removeCookies(array $keys) {
            $params = session_get_cookie_params();
            foreach ($keys as $k => $v) {
                setcookie($v, '', time() - 42000,
                    $params['path'], $params['domain'],
                    $params['secure'], $params['httponly']
                );
            }
        }
	}
}
