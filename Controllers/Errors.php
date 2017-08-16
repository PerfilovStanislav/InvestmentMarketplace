<?php

namespace Controllers {
	use Core\{Controller,Database,Auth};
	use Helpers\Helper;

	class Errors extends Controller{
		private $model;

		function __construct(Database $db, Auth $auth) {
			parent::__construct($db, $auth);
//			$this->model = new Model($db);
		}

		public function show(array $page) {
		    // #TODO логирование ошибок (кто откуда пришёл)
            Helper::header(Helper::E404);
			$this->view(['content' 	=> ['Errors/404', []]]);
		}
	}

}?>