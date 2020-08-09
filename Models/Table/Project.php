<?php

namespace Models\Table;

use Core\AbstractEntity;
use Helpers\Validator;
use Interfaces\ModelInterface;
use Traits\Model;

/**
 * @property int        $id
 * @property string     $name
 * @property int        $admin
 * @property string     $url
 * @property \DateTime  $start_date
 * @property \DateTime  $add_date
 * @property int        $paymenttype
 * @property float[]    $ref_percent
 * @property float[]    $plan_percents
 * @property int[]      $plan_period
 * @property int[]      $plan_period_type
 * @property float      $min_deposit
 * @property int        $currency
 * @property int[]      $id_payments
 * @property string     $ref_url
 * @property int        $status_id
 * @property float      $rating
 * @property \DateTime  $scam_date
 */
class Project extends AbstractEntity implements ModelInterface {
    use Model;

    private static string $table = 'project';

    protected static array
        $properties = [
            'id'                 => [self::TYPE_INT,         [Validator::MIN  => 1]],
            'name'               => [self::TYPE_STRING,      [Validator::MIN  => 1, Validator::MAX => 50, Validator::REGEX => Validator::PROJECT_NAME]],
            'admin'              => [self::TYPE_INT,         [Validator::MIN  => 1]],
            'url'                => [self::TYPE_STRING,      [Validator::MIN  => 1, Validator::MAX => 64]],
            'start_date'         => [self::TYPE_DATE,        []],
            'add_date'           => [self::TYPE_DATE,        []],
            'paymenttype'        => [self::TYPE_INT,         [Validator::MIN  => 1, Validator::MAX => 3]],
            'ref_percent'        => [self::TYPE_FLOAT_ARRAY, [Validator::MIN  => 0.01]],
            'plan_percents'      => [self::TYPE_FLOAT_ARRAY, [Validator::MIN  => 0.01, Validator::MAX  => 99_999.99]],
            'plan_period'        => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1, Validator::MAX => 10000]],
            'plan_period_type'   => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1, Validator::MAX => 6]],
            'currency'           => [self::TYPE_INT,         [Validator::MIN  => 1, Validator::MAX => 8]],
            'min_deposit'        => [self::TYPE_FLOAT,       [Validator::MIN  => 0.000_001, Validator::MAX  => 999_999.999_999]],
            'id_payments'        => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1, Validator::MAX => 30]],
            'ref_url'            => [self::TYPE_STRING,      [Validator::MIN  => 1, Validator::MAX => 128]],
            'status_id'          => [self::TYPE_INT,         [Validator::MIN  => 1]],
            'rating'             => [self::TYPE_FLOAT,       [Validator::MIN  => 0, Validator::MAX => 10]],
            'scam_date'          => [self::TYPE_DATE,        [], self::TYPE_NULLABLE],
        ];
}
