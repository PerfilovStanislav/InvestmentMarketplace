<?php

namespace Core {

    use Helpers\{
        Validator, Errors, Locale
    };

	class Auth
	{
		private $db;
		CONST PREFIX = '$2a$08$';
		private static $isAuthorized = null;
		private static $sessionStarted = false;
		private static $userInfo = null;


		function __construct(Database $db) {
			$this->db = $db;

			self::startSession();

			$s = &$_SESSION;
			$c = &$_COOKIE;

			if (isset($s['user_id'])) {
                self::setUserInfoFromBase($s['user_id']);
			}
			else if (isset($c['user_id']) && isset($c['hash'])) {
				$user_id = Validator::replace(Validator::NUM,  $c['user_id']);
				$hash 	 = Validator::replace(Validator::HASH, $c['hash']);
				setcookie('user_id' , $user_id,	null,'/',DOMAIN,null,false);
				setcookie('hash'	, $hash,	null,'/',DOMAIN,null,false);

				if ($this->db->getOne('user_remember', 'hash', "user_id = {$user_id} and hash = '{$hash}' and ip='{$this->get_ip()}'")) {
					$s['user_id'] = $c['user_id'];
                    self::setUserInfoFromBase($s['user_id']);
				}
				else {
					self::$isAuthorized = false;
				}
			}
		}

		public static final function isAuthorized() {
			return self::$isAuthorized;
		}

		private final static function startSession() {
			if (!self::$sessionStarted) {
				session_name('uid');
				session_set_cookie_params(1728000, '/', DOMAIN, false, true);
				session_start();
				self::$sessionStarted = true;
			}
		}

		public function authorize($login, $password) {
			if (strpos($login, '@') > 0) {
				$email = Validator::replace(Validator::EMAIL, $login);
				$res = $this->db->getOne('users', 'id, password', "email = '$email'");
			}
			else {
				$login = Validator::replace(Validator::EN, $login);
				$res = $this->db->getOne('users', 'id, password', "login = '$login'");
			}

			if (!$res) {
				Errors::setField('login', 'no_user');
				return Errors::getErrors();
			}

			if (self::confirmPassword($password, $res['password'])) {
				self::startSession();
				$s = &$_SESSION;

				setcookie('user_id', $res['id'],null,'/',DOMAIN,null,true);
				$s['user_id'] = $res['id'];

				$res = $this->db->getOne('user_remember', 'hash', "user_id = '{$res['id']}' and ip = '{$this->get_ip()}'");
				if ($res) {
					setcookie('hash', $res['hash'],null,'/',DOMAIN,null,true);
				}
				elseif (($_POST['remember'] ?? '') === 'on') {
					$hash = self::hashPassword(uniqid('rand'.$s['user_id'].$this->get_ip(), true));
					setcookie('hash', $hash,null,'/',DOMAIN,null,true);
					$this->db->insert('user_remember', [
						'user_id' 	=> [[$s['user_id']],	\PDO::PARAM_INT],
						'hash' 		=> [[$hash]],
						'ip' 		=> [[$this->get_ip()]]
					]);
				}
				return ['success' => 'user_authorized'];
			}
			else {
				Errors::setField('password', 'bad_password');
				return Errors::getErrors();
			}
		}

		public function logout() {
			if (!self::$isAuthorized) return false;

			self::startSession();

			$info = self::$userInfo;
			$this->db->deleteOne('user_remember', "user_id={$info['id']} and ip='{$this->get_ip()}'");

			$session_keys_in_cookies = ['uid', 'hash', 'user_id'];
			$params = session_get_cookie_params();
			foreach ($session_keys_in_cookies as $k => $v) {
				setcookie($v, '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			session_destroy();
			return true;
		}

		private final static function confirmPassword($password, $hash)
		{
			return crypt($password, self::PREFIX.$hash) === self::PREFIX.$hash;
		}

		public final static function hashPassword($password)
		{
			$salt = substr(md5(uniqid('St', true)), 0, 22);
			return substr(crypt($password, self::PREFIX . $salt), 7);
		}

		public final function setUserInfoFromBase($id) {
			self::$isAuthorized = true;
			self::$userInfo = $this->db->getOne('users u 
			    left join user_params up ON up.user_id = u.id 
			    left join languages l ON l.id = up.lang_id', 'u.id, u.login, u.status_id, u.name, l.shortname as lang', "u.id = {$id}");
		}

		public final static function getUserInfo() {
			return self::$userInfo;
		}

		private function get_ip():string
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
			$ip = Validator::replace(Validator::IP, $ip);
			return $ip;
		}
	}
}

?>