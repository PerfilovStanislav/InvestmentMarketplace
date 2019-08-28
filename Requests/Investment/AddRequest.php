<?php

namespace Requests\Investment;

use Core\AbstractEntity;
use Helpers\Arrays;
use Helpers\Locale;
use Helpers\Validator;
use Interfaces\EntityInterface;
use Models\Constant\ProjectStatus;
use Models\Table\Language;

/**
 * @property string     $name
 * @property integer    $paymenttype
 * @property \DateTime  $start_date
 * @property float[]    $ref_percent
 * @property float[]    $plan_percents
 * @property integer[]  $plan_period
 * @property integer[]  $plan_period_type
 * @property float[]    $plan_start_deposit
 * @property integer[]  $plan_currency_type
 * @property integer[]  $id_payments
 * @property string[]   $description
 * @property integer[]  $lang_id
 * @property string     $screen_data
 * @property string     $thumb_data
 */
class AddRequest extends AbstractEntity implements EntityInterface {

    protected $data;

    protected static
        $defaults = null,
        $properties = [
            'name'               => [self::TYPE_STRING,       [Validator::MIN => 1, Validator::MAX => 50, Validator::REGEX => Validator::PROJECT_NAME]],
            'paymenttype'        => [self::TYPE_INT,          [Validator::MIN => 1, Validator::MAX => 3]],
            'start_date'         => [self::TYPE_DATE,         []],
            'ref_percent'        => [self::TYPE_FLOAT_ARRAY,  [Validator::MIN  => 0.01]],
            'plan_percents'      => [self::TYPE_FLOAT_ARRAY,  [Validator::MIN  => 0.01]],
            'plan_period'        => [self::TYPE_INT_ARRAY,    [Validator::MIN  => 1]],
            'plan_period_type'   => [self::TYPE_INT_ARRAY,    [Validator::MIN  => 1, Validator::MAX => 6]],
            'plan_start_deposit' => [self::TYPE_FLOAT_ARRAY,  [Validator::MIN  => 0.00001]],
            'plan_currency_type' => [self::TYPE_INT_ARRAY,    [Validator::MIN  => 1, Validator::MAX => 8]],
            'id_payments'        => [self::TYPE_INT_ARRAY,    [Validator::MIN  => 1, Validator::MAX => 30]],
            'description'        => [self::TYPE_STRING_ARRAY, [Validator::MIN  => 1, Validator::MAX => 5000]],
            'lang_id'            => [self::TYPE_INT_ARRAY,    [Validator::MODEL => Language::class]],
            'screen_data'        => [self::TYPE_STRING,       [Validator::MIN  => 1, Validator::MAX => 1000000]],
            'thumb_data'         => [self::TYPE_STRING,       [Validator::MIN  => 1, Validator::MAX => 200000]],
        ];
}
