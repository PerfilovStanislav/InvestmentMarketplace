<?php

namespace Controllers;

use Core\Controller;
use Dto\DefaultRoute;
use Helpers\Output;
use Requests\LanguageAvailableRequest;

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