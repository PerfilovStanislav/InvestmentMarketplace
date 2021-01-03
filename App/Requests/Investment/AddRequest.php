<?php

namespace App\Requests\Investment;

use App\Requests\AbstractRequest;
use App\Helpers\Validator;
use App\Models\Table\Project;

/**
 * @property string     $name
 * @property integer    $paymenttype
 * @property \DateTime  $start_date
 * @property float[]    $ref_percent
 * @property float[]    $plan_percents
 * @property integer[]  $plan_period
 * @property integer[]  $plan_period_type
 * @property float      $min_deposit
 * @property integer    $currency
 * @property integer[]  $id_payments
 * @property string[]   $description
 */
class AddRequest extends AbstractRequest {

    protected static array
        $properties = [
            'description' => [self::TYPE_STRING_ARRAY, [Validator::MIN  => 1, Validator::MAX => 5000]],
        ];

    public function __construct(array $data = [])
    {
        static::$properties = array_replace(
            static::$properties,
            Project::getPropertiesByKeys(['name', 'paymenttype', 'start_date', 'ref_percent', 'plan_percents',
                'plan_period', 'plan_period_type', 'min_deposit', 'currency', 'id_payments', ])
        );
        parent::__construct($data);

    }
}
