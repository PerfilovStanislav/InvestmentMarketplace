<?php

namespace Core {
	use Libraries\PregReplace;
	
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

				if (isset($s['user'])) {
					$this->setUserInfo($s['user']);
				}
				else if (isset($c['user']) && isset($c['hash'])) {
					setcookie('user', PregReplace::replace('num',  $c['user']),null,'/',DOMAIN,null,false);
					setcookie('hash', PregReplace::replace('hash', $c['hash']),null,'/',DOMAIN,null,false);

					$hash = $this->db->getOne('user_remember', 'hash', "user_id = {$c['user']} and hash = '{$c['hash']}'");
					if ($hash) {
						$s['user'] = $c['user'];
						$s['hash'] = $hash['hash'];
						$this->setUserInfo($s['user']);
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
				$email = PregReplace::replace('email', $login);
				$res = $this->db->getOne('user', 'id, hashpass', "email = '$email'");
			}
			else {
				$login = PregReplace::replace('en', $login);
				$res = $this->db->getOne('user', 'id, hashpass', "login = '$login'");
			}

			if (!$res) return 'badUser';

			if (self::confirmPassword($password, $res['hashpass'])) {
				self::startSession();
				$s = &$_SESSION;

				setcookie('user', $res['id'],null,'/',DOMAIN,null,true);
				$s['user'] = $res['id'];
				$res = $this->db->getOne('user_remember', 'hash', "user_id = '{$res['id']}'");
				if ($res) {
					setcookie('hash', $res['hash'],null,'/',DOMAIN,null,true);
					return 'userAuthorized';
				}
				else {
					$hash = self::hashPassword(uniqid('rand'.$s['user'], true));
					setcookie('hash', $hash,null,'/',DOMAIN,null,true);
					$this->db->insert('user_remember', [
						'user_id' => $s['user'],
						'hash' => $hash
					])->execute();
				}
			}
			else {
				return 'badPassword';
			}
		}

		public function logout() {
			setcookie('hash', '', time()-3600);
			setcookie('user', '', time()-3600);
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