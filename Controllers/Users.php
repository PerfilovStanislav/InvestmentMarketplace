<?php

namespace Controllers {
	use Core\Controller;
	use Core\Database;
	use Core\View;
	use Core\Auth;

	class Users extends Controller{
		function __construct(Database $db, Auth $auth) {
			parent::__construct(__CLASS__, $db, $auth);
		}

		public function registration(array $page) {
			echo json_encode(['ttt' => (new View('Users/Registration', ['payments' => 111]))->get()]);
		}
	}

}?>