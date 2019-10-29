<?php

namespace Controllers {

    use Core\{Controller, Router};
    use Helpers\Output;
    use Requests\{LanguageAvailableRequest,};

    class Promo extends Controller {

        public function show(LanguageAvailableRequest $request) {
            if ($request->lang) {
                $_SESSION['lang'] = $request->lang;
            }

            Output::addFunction('changeUrl', ['url' => Router::DEFAULT_PARAMS], Output::DOCUMENT);

            Router::getInstance()->setUri(Router::DEFAULT_PARAMS)->startRoute();
        }
    }
}