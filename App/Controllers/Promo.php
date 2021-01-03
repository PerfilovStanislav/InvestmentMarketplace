<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Dto\DefaultRoute;
use App\Helpers\Output;
use App\Requests\LanguageAvailableRequest;

class Promo extends Controller {

    public function show(LanguageAvailableRequest $request): Output {
        if ($request->lang) {
            $_SESSION['lang'] = $request->lang;
        }

        $router = new DefaultRoute();
        Output()->addFunction('changeUrl', ['url' => $router->generateUrl()], Output::DOCUMENT);

        return Router()->go(new DefaultRoute());
    }
}