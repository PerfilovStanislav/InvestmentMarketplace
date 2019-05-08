<?php

namespace Controllers {

	use Core\Controller;
	use Helpers\Helper;
	use Views\Errors\Error404 as Error404;

	class Errors extends Controller {

        function __construct() {
            parent::__construct();
        }

		// #TODO логирование ошибок (кто откуда пришёл)
		public function show(array $page = []) {
            Helper::header(Helper::E404);
            Helper::$r['c']['content'] = [Error404::class, []];
		}
	}

}