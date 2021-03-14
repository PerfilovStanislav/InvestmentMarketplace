<?php

namespace App\Requests\Purchase;

use App\Models\File;
use App\Requests\AbstractRequest;
use App\Helpers\Validator;

/**
 * @property integer    $position
 * @property \DateTime  $start_date
 * @property \DateTime  $end_date
 * @property File       $banner
 * @property string     $contact
 * @property string     $url
 */
class PrepareRequest extends AbstractRequest {

    protected static array
        $properties = [
            'position'      => [self::TYPE_INT,    [Validator::IN => [1,2]]],
            'start_date'    => [self::TYPE_DATE,   []],
            'end_date'      => [self::TYPE_DATE,   []],
            'banner'        => [self::TYPE_FILE,   []],
            'contact'       => [self::TYPE_STRING, [Validator::MAX => 50]],
            'url'           => [self::TYPE_STRING, [Validator::REGEX => Validator::SITE_URI]],
        ];

}
