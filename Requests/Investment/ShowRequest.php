<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Arrays;
use Helpers\Locale;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Constant\ProjectStatus;

/**
 * @property int    $page
 * @property string $lang
 * @property string $status
 */
class ShowRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'lang'   => [self::TYPE_STRING,     [Validator::REGEX => Validator::EN]],
            'page'   => [self::TYPE_INT,        [Validator::MIN => 1, Validator::MAX => 50, ]],
            'status' => [self::TYPE_CONSTANTS,  ProjectStatus::class],
        ];

    public static function getDefaults(): self
    {
        return self::$defaults ?: new self([
            'lang'   => Locale::getLanguage(),
            'page'   => 1,
            'status' => ProjectStatus::getConstName(ProjectStatus::ACTIVE),
        ]);
    }

    public function getUriWithNewParam(array $params) : string {
        return Arrays::toUri(array_merge($this->toArray(), $params));
    }
}