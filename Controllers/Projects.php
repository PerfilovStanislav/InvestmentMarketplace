<?php

namespace Controllers {
	use Core\Controller;
	use Core\Database;
	use Core\View;
	use Core\Auth;
	use Core\ViewPrepare;

	class Projects extends Controller{
		function __construct(Database $db, Auth $auth) {
			parent::__construct(__CLASS__, $db, $auth);
		}

		public function registration(array $page) {
			$this->view(['content' 	=> ['Projects/Registration', $this->model->getData()]]);
		}

		public function add() {
			$this->model->saveProject($_POST);
		}
/*
		public function add(array $page) {
//			print_r($page);

			$ajax = false;
			$content = (new View('Addproject', ['aaa' => 'a', 'bbb' => 'b']))->get();
			if ($ajax) {
				echo $content;
			}
			else {
				echo (new View('Layout', ['content' => $content]))->get();
			}

			//$this->model->query('select * from project');
		}*/
	}

}?>