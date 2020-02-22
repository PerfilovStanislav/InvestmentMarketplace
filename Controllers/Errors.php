<?php

namespace Controllers;

use Core\Controller;
use Helpers\Output;
use Views\Errors\ErrorDefault;

class Errors extends Controller {

    // #TODO логирование ошибок (кто откуда пришёл)
    public function show(array $data = []) {
        Output()->addView(ErrorDefault::class, $data);
    }
}