<?php

namespace Controllers {

	use Core\Controller;
	use Helpers\Output;
	use Views\Errors\Error404;

	class Errors extends Controller {

        function __construct() {
            parent::__construct();
        }

		// #TODO логирование ошибок (кто откуда пришёл)
		public function show() {
            Output::header(Output::E404);
            Output::$r['c']['content'] = [Error404::class, []];
		}
	}

}