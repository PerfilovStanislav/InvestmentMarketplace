<?php

namespace Models\Constant;

use Interfaces\ConstantInterface;
use Traits\Collection;

class Payment implements ConstantInterface {
    use Collection;

    public const
        VISA            = 1,
        TWO_CO          = 2,
        ADVCASH         = 3,
        AMERICANEXPRESS = 4,
        BITCOIN         = 5,
        CIRRUS          = 6,
        DELTA           = 7,
        DISCOVER        = 8,
        MASTERCARD      = 9,
        MONEYBOOKERS    = 10,
        PAYPAL          = 11,
        PAYEER          = 12,
        PAYZA           = 13,
        PERFECTMONEY    = 14,
        QIWI            = 15,
        SOLO            = 16,
        SWITCH          = 17,
        WESTERNUNION    = 18,
        LIQPAY          = 19,
        NETELLER        = 20,
        NIXMONEY        = 21,
        OKPAY           = 22,
        SOLIDTRUSTPAY   = 23,
        WEBMONEY        = 24,
        YANDEX          = 25,
        BITCOINCASH     = 26,
        ETHEREUM        = 27,
        LITECOIN        = 28,
        DOGECOIN        = 29,
        DASHCOIN        = 30;
}
