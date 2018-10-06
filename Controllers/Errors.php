<?php

namespace Controllers {
	use \Models\Hyip as Model;
	use Helpers\Helper;

	class Errors extends Layout {
		private $model;

		function __construct() {
			parent::__construct();
			$this->model = new Model();
		}

		// #TODO логирование ошибок (кто откуда пришёл)
		public function show(array $page) {
			$return = [];
			$return['c']['content'] = ['Errors/404', []];

            Helper::header(Helper::E404);
			return IS_AJAX ? Helper::json($return) : $this->layout($return);
		}
	}

}?>