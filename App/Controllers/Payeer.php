<?php

namespace App\Controllers;

use App\Core\{Controller};
use App\Helpers\Output;
use App\Services\PayeerService;
use App\Views\Purchase\Banners\StatusFail;
use App\Views\Purchase\Banners\StatusSuccess;

class Payeer extends Controller {

    public function success(array $data): Output {
        PayeerService::getInstance()->success($data);

        return Output()
            ->addView(StatusSuccess::class, [
                'status' => $data['m_status'] ?? 'error'
            ]);
    }

    public function fail(array $data): Output {
        return Output()
            ->addView(StatusFail::class, [
                'status' => base64_decode($data['m_desc']) ?? ''
            ]);
    }

    public function status(array $data): Output {
        \Output()->disableLayout();

        if (!in_array($_SERVER['REMOTE_ADDR'], ['185.71.65.92', '185.71.65.189', '149.202.17.210'])) {
            return Output();
        }

        if (isset($data['m_operation_id']) && isset($data['m_sign'])) {
            $m_key = \Config::PAYEER_SECRET_KEY;

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
                $data['m_status']
            ];

            if (isset($data['m_params'])) {
                $arHash[] = $data['m_params'];
            }

            $arHash[] = $m_key;

            $sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

            if ($data['m_sign'] === $sign_hash && $data['m_status'] === 'success') {
                ob_end_clean();
                exit($data['m_orderid'] . '|success');
            }

            ob_end_clean();
            exit($data['m_orderid'] . '|error');
        }

        return Output()
            ->addView(StatusSuccess::class, [
                'status' => 'Status'
            ]);
    }
}
