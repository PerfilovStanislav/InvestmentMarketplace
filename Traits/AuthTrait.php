<?php

namespace Traits;

use Exceptions\ErrorException;

trait AuthTrait
{
//    private static function needAuthorization() {
//        if (!AuthModel::getInstance()->user) {
//            output()->addAlertDanger(Locale()->getLocale()->error, Locale()->getLocale()->needAuthorization);
//            return output()->result();
//        }
//    }

    private static function adminAccess() {
        if (!CurrentUser()->isAdmin()) {
            Output()->addAlertDanger(Translate()->error, Translate()->noAccess);
            throw new ErrorException(Translate()->error, Translate()->noAccess, 403);
        }
    }
}