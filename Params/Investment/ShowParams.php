<?php

namespace Params\Investment;

use Helpers\Arrays;
use Helpers\Locale;
use Models\ProjectStatus;
use Params\AbstractParams;

/**
 * @property int $page
 * @property string $lang
 * @property string $status
 * Class AbstractParams
 * @package Params
 */
class ShowParams extends AbstractParams {
    protected $data;
    public static $defaults = null;

    final public function __construct(array $params, bool $setDefaults = true) {
        if ($setDefaults) {
            self::$defaults = new ShowParams([
                'lang' => Locale::getLanguage(),
                'page' => 1,
                'status' => ProjectStatus::ACTIVE,
            ], false);
        }
        parent::__construct($params);
    }

    final public function getUriWithNewParam(array $params) : string {
        return Arrays::toUri(array_merge($this->get(), $params));
    }

}