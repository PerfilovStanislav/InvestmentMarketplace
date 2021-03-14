<?php

namespace App\Services;

use App\Models\Constant\OrderStatus;
use App\Queries\Orders\Update;
use App\Traits\Instance;

class PayeerService {
    use Instance;

    public function getUrl(float $sum, int $orderId)
    {
        $shop     = 1284900525;
        $amount   = number_format($sum, 2, '.', '');
        $curr     = 'USD'; // USD, RUB, EUR, BTC, ETH, BCH, LTC, DASH, USDT, XRP
        $desc     = base64_encode("Buy banner");

        $arHash = [$shop, $orderId, $amount, $curr, $desc, \Config::PAYEER_SECRET_KEY];
        $sign = strtoupper(hash('sha256', implode(':', $arHash)));

        return 'https://payeer.com/merchant/?'.http_build_query([
            'm_shop'    => $shop,
            'm_orderid' => $orderId,
            'm_amount'  => $amount,
            'm_curr'    => $curr,
            'm_desc'    => $desc,
            'm_sign'    => $sign,
        ]);
    }

    public function success(array $data) {
        $arHash = [
            $data['m_operation_id'],
            $data['m_operation_ps'],
            $data['m_operation_date'],
            $data['m_operation_pay_date'],
            $data['m_shop'],
            $data['m_orderid'],
            $data['m_amount'],
            $data['m_curr'],
            $data['m_desc'],
            $data['m_status'],
            \Config::PAYEER_SECRET_KEY
        ];
        $sign = strtoupper(hash('sha256', implode(':', $arHash)));

        $status = OrderStatus::getValue($data['m_status']);
        if ($sign === $data['m_sign'] && $status === OrderStatus::SUCCESS) {
            Db()->rawExecute(
                Update::index($data['m_orderid'], $status, $data)
            );
        }
    }
}