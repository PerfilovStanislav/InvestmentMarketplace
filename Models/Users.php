<?php

namespace Models {

	use Core\Database;
	use Core\Model;
	use Libraries\File;
	use Libraries\Cleaner as Valid;
	use Libraries\Validator;
	use \Core\Auth;
	use \Helpers\Errors;

	class Users extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		public function addUser(array $post) {
			if ($user = $this->db->getOne('user', 'login, email', "login = '{$post['login']}' or email = '{$post['email']}'")) {
				if ($user['login'] === $post['login']) Errors::setField('name', 'login_is_busy');
				if ($user['email'] === $post['email']) Errors::setField('name', 'email_is_busy');
				return Errors::getErrors();
			}

			$post['password'] = Auth::hashPassword($post['password']);
			$this->db->insert('user', $post);
			if ($this->db->execute()) {
//				$user_id = $this->db->lastID('user');
				return ['success' => 'userAdded'];
			}
		}
	}

}?>