<?php

namespace Models {

	use Core\Database;
	use Core\Model;
	use Libraries\File;
	use Libraries\Validation as Valid;

	class Users extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		public function addUser(array $post) {
			if (Valid::issetKeys($post, ['login', 'name', 'email', 'password'])) {
				die('OK');
			}
			else die('BadUser');

			$data = [
				'login' 		=> Valid::replace(Valid::EN, $post['login']),
				'name' 			=> Valid::replace(Valid::TEXT, $post['name']),
				'email' 		=> Valid::replace(Valid::EMAIL, $post['email']),
				'pass' 			=> str_replace('"', '\"', $post['password']) // #TODO ... сохранять hash
			];

			$this->db->insert('user', $data);

			if ($this->db->execute()) {
				$user_id = $this->db->lastID('user');
				echo $user_id;
			}
		}
	}

}?>