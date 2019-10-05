<?php

namespace Models\Table {

    use Core\AbstractEntity;
    use Helpers\Validator;
    use Interfaces\EntityInterface;
    use Interfaces\ModelInterface;
    use Traits\Model;

    /**
     * @property int    $id
     * @property string $name
     * @property int    $admin
     * @property string $url
     * @property string $start_date
     * @property string $add_date
     * @property int    $paymenttype
     * @property array  $ref_percent
     * @property array  $plan_percents
     * @property array  $plan_period
     * @property array  $plan_period_type
     * @property array  $plan_start_deposit
     * @property array  $plan_currency_type
     * @property array  $id_payments
     * @property string $ref_url
     * @property int    $status_id
     */
    class Project extends AbstractEntity implements EntityInterface, ModelInterface {
        use Model;

        private static $table = 'project';

        protected $data;

        protected static
            $defaults = null,
            $properties = [
                'id'                 => [self::TYPE_INT,         [Validator::MIN  => 1]],
                'name'               => [self::TYPE_STRING,      [Validator::MIN  => 1, Validator::MAX => 50]],
                'admin'              => [self::TYPE_INT,         [Validator::MIN  => 1]],
                'url'                => [self::TYPE_STRING,      [Validator::MIN  => 1, Validator::MAX => 64]],
                'start_date'         => [self::TYPE_DATE,        []],
                'add_date'           => [self::TYPE_DATE,        []],
                'paymenttype'        => [self::TYPE_INT,         [Validator::MIN  => 1, Validator::MAX => 3]],
                'ref_percent'        => [self::TYPE_FLOAT_ARRAY, [Validator::MIN  => 0.01]],
                'plan_percents'      => [self::TYPE_FLOAT_ARRAY, [Validator::MIN  => 0.01]],
                'plan_period'        => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1]],
                'plan_period_type'   => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1]],
                'plan_start_deposit' => [self::TYPE_FLOAT_ARRAY, [Validator::MIN  => 0.00000001]],
                'plan_currency_type' => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1]],
                'id_payments'        => [self::TYPE_INT_ARRAY,   [Validator::MIN  => 1]],
                'ref_url'            => [self::TYPE_STRING,      [Validator::MIN  => 1, Validator::MAX => 128]],
                'status_id'          => [self::TYPE_INT,         [Validator::MIN  => 1]],
            ];
    }
}
