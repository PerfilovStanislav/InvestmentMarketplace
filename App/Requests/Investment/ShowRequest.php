<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Arrays;
use App\Helpers\Validator;
use App\Models\Constant\ProjectStatus;

/**
 * @property int    $page
 * @property string $lang
 * @property string $status
 */
class ShowRequest extends AbstractRequest {

    protected static array
        $properties = [
            'lang'   => [self::TYPE_STRING,     [Validator::REGEX => Validator::EN]],
            'page'   => [self::TYPE_INT,        [Validator::MIN => 1, Validator::MAX => 50, ]],
            'status' => [self::TYPE_CONSTANTS,  ProjectStatus::class],
        ];

    public static function getDefaults(): array {
        return [
            'lang'   => App()->locale()->getLanguage(),
            'page'   => 1,
            'status' => ProjectStatus::getConstNameLower(ProjectStatus::ACTIVE),
        ];
    }

    public function getUriWithNewParam(array $params): string {
        return Arrays::toUri(array_merge($this->toArray(), $params));
    }
}