<?php
namespace App\Views\Purchase\Banners;
{

    /**
     * @var BannersShow $this
     * @property int $shop
     * @property int $orderId
     * @property float $amount
     * @property string $curr
     * @property string $desc
     * @property string $key
     * @property string $sign
     */
    class Payeer
    {
    }
}

use App\Helpers\Locales\AbstractLanguage;
use App\Models\Constant\Views;
use App\Models\CurrentUser;
use App\Models\Table\Language;
use App\Models\Table\Payment;

?>

<div class="tray tray-center">
    <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-success">
            <div class="panel-heading">
        <span class="panel-title">
          <i class="fa fa-pencil-square"></i><?= Translate()->addProject ?>
        </span>
            </div>
            <form method="POST" action="https://payeer.com/ajax/api/api.php" >
                <input type="hidden" name="m_shop"    value="<?=$this->shop?>">
                <input type="hidden" name="m_orderid" value="<?=$this->orderId?>">
                <input type="hidden" name="m_amount"  value="<?=$this->amount?>">
                <input type="hidden" name="m_curr"    value="<?=$this->curr?>">
                <input type="hidden" name="m_desc"    value="<?=$this->desc?>">
                <input type="hidden" name="m_sign"    value="<?=$this->sign?>">
                <input type="submit"                  value="send" />
<!--                <div class="panel-footer text-right">-->
<!--                    <button type="submit"-->
<!--                            class="button btn-success"> --><?//= Translate()->sendForm ?><!-- </button>-->
<!--                </div>-->
            </form>

        </div>
    </div>
</div>