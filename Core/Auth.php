<?php

namespace Core {
	use Libraries\Validation as Valid;

	class Auth
	{

		private $db;
		CONST PREFIX = '$2a$08$';
		private static $isAuthorized = null;
		private static $sessionStarted = false;
		private static $userInfo = null;


		function __construct(Database $db) {
			$this->db = $db;
		}

		public function isAuthorized()
		{
			if (self::$isAuthorized === null) {
				self::startSession();

				$s = &$_SESSION;
				$c = &$_COOKIE;

				if (isset($s['user_id'])) {
					$this->setUserInfo($s['user_id']);
				}
				else if (isset($c['user_id']) && isset($c['hash'])) {
					$user_id = Valid::replace(Valid::NUM,  $c['user_id']);
					$hash 	 = Valid::replace(Valid::HASH, $c['hash']);
					setcookie('user_id' , $user_id,	null,'/',DOMAIN,null,false);
					setcookie('hash'	, $hash,	null,'/',DOMAIN,null,false);

					$hash = $this->db->getOne('user_remember', 'hash', "user_id = {$user_id} and hash = '{$hash}'");
					if ($hash) {
						$s['user_id'] = $c['user_id'];
						$s['hash'] = $hash['hash'];
						$this->setUserInfo($s['user_id']);
					}
					else {
						self::$isAuthorized = false;
					}
				}
			}
			return self::$isAuthorized;
		}

		private final static function startSession() {
			if (!self::$sessionStarted) {
				session_name('uid');
				session_set_cookie_params(172800, '/', DOMAIN, false, true);
				session_start();
				self::$sessionStarted = true;
			}
		}

		public function authorize($login, $password) {
			if (strpos($login, '@') > 0) {
				$email = Valid::replace(Valid::EMAIL, $login);
				$res = $this->db->getOne('user', 'id, hashpass', "email = '$email'");
			}
			else {
				$login = Valid::replace(Valid::EN, $login);
				$res = $this->db->getOne('user', 'id, hashpass', "login = '$login'");
			}

			if (!$res) return 'badUser';

			if (self::confirmPassword($password, $res['hashpass'])) {
				self::startSession();
				$s = &$_SESSION;

				setcookie('user_id', $res['id'],null,'/',DOMAIN,null,true);
				$s['user_id'] = $res['id'];
				$res = $this->db->getOne('user_remember', 'hash', "user_id = '{$res['id']}'");
				if ($res) {
					setcookie('hash', $res['hash'],null,'/',DOMAIN,null,true);
				}
				else {
					$hash = self::hashPassword(uniqid('rand'.$s['user'], true));
					setcookie('hash', $hash,null,'/',DOMAIN,null,true);
					$this->db->insert('user_remember', [
						'user_id' => $s['user_id'],
						'hash' => $hash
					])->execute();
				}
				return 'userAuthorized';
			}
			else {
				return 'badPassword';
			}
		}

		public function logout() {
			self::startSession();
			$session_keys_in_cookies = ['uid', 'hash', 'user_id'];
			$params = session_get_cookie_params();
			foreach ($session_keys_in_cookies as $k => $v) {
				setcookie($v, '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			session_destroy();
		}

		private final static function confirmPassword($password, $hash)
		{
			return crypt($password, self::PREFIX.$hash) === self::PREFIX.$hash;
		}

		private final static function hashPassword($password)
		{
			$salt = substr(md5(uniqid('St', true)), 0, 22);
			return substr(crypt($password, self::PREFIX . $salt), 7);
		}

		public final function setUserInfo($id) {
			self::$isAuthorized = true;
			self::$userInfo = $this->db->getOne('user', 'name', "id = {$id}");
		}

		public final static function getUserInfo() {
			return self::$userInfo;
		}
	}
}

?>