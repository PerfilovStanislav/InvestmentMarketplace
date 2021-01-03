<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Output;
use App\Views\Errors\ErrorDefault;

class Errors extends Controller {

    // #TODO логирование ошибок (кто откуда пришёл)
    public function show(array $data = []): Output {
        return Output()->addView(ErrorDefault::class, $data);
    }
}