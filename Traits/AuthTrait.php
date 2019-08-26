<?php

namespace Traits;


use Helpers\Locale;
use Helpers\Output;
use Models\AuthModel;

trait AuthTrait
{
    private static function needAuthorization() {
        if (!AuthModel::getInstance()->user) {
            Output::addAlertDanger(Locale::get('error'), Locale::get('need_authorization'));
            return Output::result();
        }
    }
}