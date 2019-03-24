<?php

namespace Models {
	use Core\{Database, Model, Auth};
	use Helpers\{
		Helper, Locale, Validator, Errors
	};
    use Models\Main;

	class Users extends Model{

		function __construct() {
            parent::__construct();
		}

		final public function addUser(Validator $post) {
		    $data = $post->getData();
		    $scope = 'adduser_form';

			if ($user = $this->db->getRow('users', 'login, email', "login = '{$data['login']}' or email = '{$data['email']}'")) {
				if ($user['login'] === $data['login']) return Helper::fieldError('login', 'login_is_busy', $scope);
				if ($user['email'] === $data['email']) return Helper::fieldError('email', 'email_is_busy', $scope);
			}

			if ($this->db->insert('users', [
                    'login' 	=> [[$data['login']]],
                    'name' 		=> [[$data['name']]],
                    'email' 	=> [[$data['email']]],
                    'password' 	=> [[Auth::hashPassword($data['password'])]]
                ])) {

			    // Add UserParams
			    $user_id = $this->db->lastID('users', "login = '{$data['login']}'");
                $lang_id = $this->db->getOne('languages', "shortname = '".Locale::getLanguage()."'");

                $this->db->insert('user_params', [
                    'user_id' 	=> [[$user_id]],
                    'lang_id' 	=> [[$lang_id]]
                ]);

				return ['success' => 'user_added'];
			}
			else return ['error' => ['user' => ['adding_error']]];
		}

		final public function getUsersByIds(array $ids) {
			return $this->db->select('users', 'id,name,login,status_id', ['id' => $ids]);
		}
	}
}
