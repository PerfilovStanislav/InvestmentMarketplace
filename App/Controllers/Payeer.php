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
}
