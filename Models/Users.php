<?php

namespace Models {
	use Core\{Database, Model, Auth};
    use Helpers\{Validator, Errors};

	class Users extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		public function addUser(Validator $post) {
		    $data = $post->getData();
			if ($user = $this->db->getOne('users', 'login, email', "login = '{$data['login']}' or email = '{$data['email']}'")) {
				if ($user['login'] === $data['login']) Errors::setField('login', 'login_is_busy');
				if ($user['email'] === $data['email']) Errors::setField('email',  'email_is_busy');
				return Errors::getErrors();
			}

			if ($this->db->insert('users', [
                    'login' 	=> [[$data['login']]],
                    'name' 		=> [[$data['name']]],
                    'email' 	=> [[$data['email']]],
                    'password' 	=> [[Auth::hashPassword($data['password'])]]
                ])) {
				return ['success' => 'user_added'];
			}
			else return ['error' => ['user' => ['adding_error']]];
		}
	}

}