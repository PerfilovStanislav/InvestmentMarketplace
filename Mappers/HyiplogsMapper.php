<?php

namespace Mappers;

use Models\Constant\PaymentType;

class HyiplogsMapper
{
    public function payments(array $payments) {
        return array_intersect_key([
            'VISA'            => 1,
            '2co'             => 2,
            'Advcash'         => 3,
            'AmericanExpress' => 4,
            'Bitcoin'         => 5,
            'Cirrus'          => 6,
            'Delta'           => 7,
            'Discover'        => 8,
            'MasterCard'      => 9,
            'MoneyBookers'    => 10,
            'PayPal'          => 11,
            'Payeer'          => 12,
            'Payza'           => 13,
            'PerfectMoney'    => 14,
            'Qiwi'            => 15,
            'Solo'            => 16,
            'Switch'          => 17,
            'WesternUnion'    => 18,
            'Liqpay'          => 19,
            'Neteller'        => 20,
            'NixMoney'        => 21,
            'OKpay'           => 22,
            'SolidTrustPay'   => 23,
            'WebMoney'        => 24,
            'Yandex'          => 25,
            'BitcoinCash'     => 26,
            'Ethereum'        => 27,
            'Litecoin'        => 28,
            'Dogecoin'        => 29,
            'Dashcoin'        => 30,
        ], array_flip($payments));
    }

    public function getPaymentTypeId(string $paymentType): int {
        if (strpos($paymentType, 'Manual') !== false) {
            return PaymentType::MANUAL;
        }
        if (strpos($paymentType, 'Instant') !== false) {
            return PaymentType::INSTANT;
        }
        if (strpos($paymentType, 'Automatic') !== false) {
            return PaymentType::AUTOMATIC;
        }

        return 0;
    }
}