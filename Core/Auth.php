<?php

namespace Core {

    use Helpers\{
		Helper, Validator
	};
    use Traits\Instance;

    class Auth {
        use Instance;

		private $db;
		CONST PREFIX = '$2a$08$';
		private static $isAuthorized = null;
		private static $sessionStarted = false;
		private static $defaultUserInfo = [
			'id'            => null,
			'session_id'    => -1
		];
		private static $userInfo;
        private static $_instance = null;

		function __construct() {
			$this->db = Database::getInstance();
			self::clearUserInfo();
			$this->login();
		}

		final private static function clearUserInfo() {
			self::$userInfo = self::$defaultUserInfo;
		}

		final private function login() {
			self::startSession();

			$s = &$_SESSION;
			$c = &$_COOKIE;

			if (isset($s['user_id'])) {
				$this->setUserInfoFromBase($s['user_id']);
			}
			else if (isset($c['user_id']) && isset($c['hash'])) {
				$user_id = Validator::replace(Validator::NUM,  $c['user_id']);
				$hash 	 = Validator::replace(Validator::HASH, $c['hash']);
				setcookie('user_id' , $user_id,	null,'/',DOMAIN,null,false);
				setcookie('hash'	, $hash,	null,'/',DOMAIN,null,false);

				if ($this->db->getRow('user_remember', 'hash', [
					'user_id' => $user_id,
					'hash' => $hash,
					'ip' => self::get_ip()
				])) {
					$s['user_id'] = $c['user_id'];
					$this->setUserInfoFromBase($s['user_id']);
				}
				else {
					self::$isAuthorized = false;
				}
			}

			self::$userInfo['session_id'] = $s['session_id']??self::getSession();
		}

		final private static function getSession():int {
			$session_id = Database::getInstance()->getOne('session', sprintf("uid = '%s'", session_id()));
			if (!$session_id) {
				$data = [
					'uid' => [[session_id()]],
					'ip' => [[self::get_ip()]],
				];
				Database::getInstance()->insert('session', $data);

				$data = [
					'uid' => $data['uid'][0][0],
					'ip' => $data['ip'][0][0],
				];
				return Database::getInstance()->getOne('session', $data);
			}
			return $session_id;
		}

		final public static function isAuthorized():bool {
			return self::$isAuthorized??false;
		}

		final private static function startSession() {
			if (!self::$sessionStarted) {
				session_name('uid');
				session_set_cookie_params(1728000, '/', DOMAIN, false, true);
				session_start();
				self::$sessionStarted = true;
			}
		}

		final public function authorize($login, $password) {
		    $scope = 'authorizationuser_form';
			if (strpos($login, '@') > 0) {
				$email = Validator::replace(Validator::EMAIL, $login);
				$res = $this->db->getRow('users', 'id, password', "email = '$email'");
			}
			else {
				$login = Validator::replace(Validator::EN, $login);
				$res = $this->db->getRow('users', 'id, password', "login = '$login'");
			}

			if (!$res) {
				Helper::fieldError('login', 'no_user', $scope);
			}

			if (self::confirmPassword($password, $res['password'])) {
				$user_id = $res['id'];
				self::startSession();
				$s = &$_SESSION;

				$this->db->update('message', [':user_id' => $user_id], 'session_id = ' . self::getSession());

				setcookie('user_id', $user_id,null,'/',DOMAIN,null,true);
				$s['user_id'] = $user_id;

				$res = $this->db->getRow('user_remember', 'hash', [
					'user_id' => $user_id,
					'ip' => self::get_ip()]);
				if ($res) {
					setcookie('hash', $res['hash'],null,'/',DOMAIN,null,true);
				}
				elseif (($_POST['remember'] ?? '') === 'on') {
					$hash = self::hashPassword(uniqid('rand'.$s['user_id'].self::get_ip(), true));
					setcookie('hash', $hash,null,'/',DOMAIN,null,true);
					$this->db->insert('user_remember', [
						'user_id' 	=> [[$s['user_id']],	\PDO::PARAM_INT],
						'hash' 		=> [[$hash]],
						'ip' 		=> [[self::get_ip()]]
					]);
				}
				$this->setUserInfoFromBase($user_id);
//				Helper::$r['success'] = 'user_authorized';
			}
			else {
				Helper::fieldError('password', 'bad_password', $scope);
			}
		}

		final public function logout():bool {
			if (!self::$isAuthorized) return false;

			self::startSession();

			$info = self::getUserInfo();
			$this->db->deleteOne('user_remember', "user_id={$info['id']} and ip='" . self::get_ip() . "'");

			$session_keys_in_cookies = ['uid', 'hash', 'user_id'];
			$params = session_get_cookie_params();
			foreach ($session_keys_in_cookies as $k => $v) {
				setcookie($v, '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			session_destroy();
			self::$isAuthorized = false;
			return true;
		}

		final private static function confirmPassword($password, $hash):bool {
			return crypt($password, self::PREFIX.$hash) === self::PREFIX.$hash;
		}

		final public static function hashPassword($password):string
		{
			$salt = substr(md5(uniqid('St', true)), 0, 22);
			return substr(crypt($password, self::PREFIX . $salt), 7);
		}

		final public function setUserInfoFromBase($id) {
			self::$isAuthorized = true;
			self::$userInfo = array_merge(self::$userInfo, $this->db->getRow('users u 
			    left join user_params up ON up.user_id = u.id 
			    left join languages l ON l.id = up.lang_id',
				'u.id, u.login, u.status_id, u.name, l.shortname as lang, up.photo',
				"u.id = {$id}"));
		}

		final public static function getUserInfo():array {
			return self::$userInfo;
		}

		final private static function get_ip():string
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
			$ip = Validator::replace(Validator::IP, $ip);
			return $ip;
		}
	}
}
