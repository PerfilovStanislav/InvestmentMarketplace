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
    class BannersShow
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
          <i class="fa fa-pencil-square"></i><?= Translate()->advertising ?>
        </span>
            </div>
            <form method="post" action="http://richinme.org/Purchase/prepare" target="_blank" >
                <div class="panel-body bg-light">
                    <div class="section row">
                        <div class="section flex">
                            <blockquote class="blockquote-success">
                                <p class="w150"><?=Translate()->bannerPosition ?></p>
                            </blockquote>
                            <div>
                                <label class="block field option option-success">
                                    <input type="radio" name="position" checked value="1">
                                    <span class="radio br-success"></span><i class="glyphicon glyphicon-arrow-up"></i> <?=Translate()->blockOnTop?> (<b>728</b>х<b>90</b>)
                                </label>

                                <label class="block mt15 field option option-success">
                                    <input type="radio" name="position" value="2">
                                    <span class="radio br-success"></span><i class="glyphicon glyphicon-arrow-left"></i>
                                    <?=Translate()->blockOnTheLeft?> (<b>125</b>х<b>125</b>)
                                </label>
                            </div>
                        </div>

                        <div class="section">
                            <label class="field prepend-icon append-button file">
                                <span class="button btn-success">Choose File</span>
                                <input type="file" class="gui-file" name="banner" required accept="image/*">
                                <input type="text" class="gui-input" placeholder="Select a file">
                                <label class="field-icon">
                                    <i class="fa fa-upload"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                            <div class="smart-widget sm-right">
                                <label class="field prepend-icon">
                                    <input name="url" class="gui-input onlyUrl" autocomplete="off"
                                           placeholder="<?= Translate()->projectUrl ?>" required>
                                    <label class="field-icon">
                                        <i class="fa fa-globe"></i>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <div class="section flex fw_w">
                            <div class="f_1_1_auto">
                                <input type="text" id="start-date" name="start_date" class="hidden" required />
                                <input type="text" id="end-date" name="end_date" class="hidden" />
                            </div>
                            <div class="f_1_1_auto mt15">
                                <div class="section flex">
                                    <blockquote class="blockquote-warning lh0_6">
                                        <p class="w150"><?=Translate()->numberOfDays?></p>
                                    </blockquote>
                                    <div class="smart-widget sm-right mw90">
                                        <label class="field prepend-icon">
                                            <input class="gui-input onlyUrl" readonly id="days_count" value="7">
                                            <label class="field-icon">
                                                <i class="fa fa-calendar"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section flex">
                                    <blockquote class="blockquote-warning lh0_6">
                                        <p class="w150"><?=Translate()->discount?></p>
                                    </blockquote>
                                    <div class="smart-widget sm-right mw90">
                                        <label class="field prepend-icon">
                                            <input class="gui-input onlyUrl" readonly id="discount" value="6">
                                            <label class="field-icon">
                                                <i class="fa fa-percent"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section flex">
                                    <blockquote class="blockquote-warning lh0_6">
                                        <p class="w150"><?=Translate()->total?></p>
                                    </blockquote>
                                    <div class="smart-widget sm-right mw90">
                                        <label class="field prepend-icon">
                                            <input class="gui-input onlyUrl" readonly id="amount" value="19.74">
                                            <label class="field-icon">
                                                <i class="fa fa-dollar"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section">
                            <div class="smart-widget sm-right">
                                <label class="field prepend-icon">
                                    <input name="contact" class="gui-input onlyUrl" autocomplete="off"
                                           placeholder="<?= Translate()->contact ?>">
                                    <label class="field-icon">
                                        <i class="fa fa-envelope-o"></i>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <div class="panel-footer text-right">
                            <button type="submit"
                                    class="button btn-success"> <?= Translate()->sendForm ?> </button>
                        </div>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </div>
            </form>

        </div>
    </div>
</div>