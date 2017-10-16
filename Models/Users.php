<?php

namespace Models {
	use Core\{Database, Model, Auth};
    use Helpers\{
        Locale, Validator, Errors
    };
    use Models\Main;

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

			    // Add UserParams
			    $user_id = $this->db->lastID('users', "login = '{$data['login']}'");
                $lang_id = Main::$db->getOne('languages', 'id', "shortname = '".Locale::getLanguage()."'")['id'];

                $this->db->insert('user_params', [
                    'user_id' 	=> [[$user_id]],
                    'lang_id' 	=> [[$lang_id]]
                ]);

				return ['success' => 'user_added'];
			}
			else return ['error' => ['user' => ['adding_error']]];
		}
	}

}