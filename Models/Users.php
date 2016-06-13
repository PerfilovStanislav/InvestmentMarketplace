<?php

namespace Models {

	use Core\Database;
	use Core\Model;
	use Libraries\File;
	use Libraries\PregReplace;

	class Users extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		public function addUser(array $post) {
			$data = [
				'login' 		=> PregReplace::replace('en', $post['login']),
				'name' 			=> PregReplace::replace('text', $post['name']),
				'email' 		=> PregReplace::replace('email', $post['email']),
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