<?php

namespace App\Controllers;

use App\Models\Constant\OrderType;
use App\Queries\Orders\Create;
use App\Requests\Purchase\PrepareRequest;
use App\Requests\Telegram\SendMessageRequest;
use App\Services\PayeerService;
use App\Views\Purchase\Banners\BannersShow;
use App\Core\{AbstractEntity, Controller};
use App\Helpers\Output;
use Jcupitt\Vips\Access;
use Jcupitt\Vips\Image;

class Purchase extends Controller {

    public function banners(array $data = []): Output {
        return Output()
            ->addView(BannersShow::class, [
            ])
            ->addFunctions([
                'initFormPurchaseBanner',
            ]);
    }

    public function prepare(PrepareRequest $r): Output {
        $count = $r->end_date->diff($r->start_date)->days + 1;
        $discount = min($count - 1, 30);
        $sum = [0, 3, 2][$r->position] * $count * (100 - $discount) / 100;

        $path = $this->getPath($r->banner->name);

        Image::newFromFile($r->banner->tmp_name, [
            'n' => -1,
            'access' => Access::SEQUENTIAL,
        ])->webpsave($path . '.webp', [
            'Q'     => 75,
            'strip' => true,
        ]);
        move_uploaded_file($r->banner->tmp_name, $path);

        $orderId = Db()->rawSelect(Create::index(
            $r->start_date->format(AbstractEntity::FORMAT_DATE),
            $r->end_date->format(AbstractEntity::FORMAT_DATE),
            $r->position,
            $r->url,
            $r->contact,
            OrderType::BANNER,
            $sum,
            basename($path)
        ))[0]['id'];

        $url = PayeerService::getInstance()->getUrl($sum, $orderId);

        App()->telegram()->sendMessage(new SendMessageRequest([
            'chat_id' => \Config::TELEGRAM_MY_ID,
            'text' => "Заказ баннера. Сумма: $sum",
        ]));
        return Output()
            ->addFunctions([
                'redirect' => ['url' => $url],
            ]);
    }

    private function getExt(string $filename, string $default = 'gif') {
        $arr = explode(".", ".$default$filename");
        return end($arr)?? $default;
    }

    private function getPath(string $filename) {
        $ext = $this->getExt($filename);
        $name = time();
        return ROOT . "/assets/bnrs/$name.$ext";
    }
}
