<?php

namespace Controllers {

	use Core\Controller;
	use Helpers\Output;
	use Views\Errors\Error404;

	class Errors extends Controller {

		// #TODO логирование ошибок (кто откуда пришёл)
		public function show() {
            Output::header(Output::E404);
            Output::addView(Error404::class);
		}
	}

}