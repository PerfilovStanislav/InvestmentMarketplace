<?php

namespace Controllers {

	use Core\Controller;
	use Helpers\Helper;
	use Views\Errors\Error404 as Error404;

	class Errors extends Controller {
		// #TODO логирование ошибок (кто откуда пришёл)
		public function show(array $page = []) {
            Helper::$r['c']['content'] = [Error404::class, []];
		}
	}

}