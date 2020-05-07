<?php
namespace Views\Contact; {

/**
 * @var Show $this
 * @property Payment[] $payments
 * @property Language[] $mainProjectLanguages
 * @property Language[] $secondaryProjectLanguages
 * @property CurrentUser $authModel
 * @property array currency
 * @property AbstractLanguage $locale
 */
Class Show {} }

use Helpers\Locales\AbstractLanguage;
use Models\Constant\Views;
use Models\CurrentUser;
use Models\Table\Language;
use Models\Table\Payment;
?>
<?php function qr(string $str) {
    return sprintf('<img src="/assets/social/empty.svg" class="mr10" width="16" height="16" href="/assets/social/%s-qr.svg" alt="QR code %s" title="QR code %s">
            <img src="/assets/social/%s.svg" width="24" height="24">', $str, $str, $str, $str);
}?>
<div class="tray tray-center">
    <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-warning">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="glyphicon glyphicon-book"></i><?=Translate()->contact?>
                </span>
            </div>
            <div class="panel-body bg-light">
                <div class="section pl28">
                    <i class="glyphicon glyphicon-map-marker text-warning glyphicon-2x fs18 ml3 mr10"></i>
                    190000, Saint-Petersburg, Russia
                </div>
                <div class="section">
                    <?=qr('email')?>
                    <a href="mailto:admin@richinme.com">
                        <span class="ml7">admin@richinme.com</span>
                    </a>
                </div>
                <div class="section">
                    <?=qr('telegram')?>
                    <a href="https://<?=App()->locale()->getLanguage() === 'ru' ? 'tele.click' : 't.me'?>/RichinmeAdmin"
                       class="ml7" target="_blank" rel="nofollow noopener">RichinmeAdmin</a>
                </div>
                <div class="section">
                    <?=qr('vk')?>
                    <a href="https://vk.com/investmentmarket" class="ml7" target="_blank" rel="nofollow noopener">InvestmentMarket</a>
                </div>
                <div class="section">
                    <?=qr('facebook')?>
                    <a href="https://fb.me/RichinmeAdmin" class="ml7" target="_blank" rel="nofollow noopener">RichinmeAdmin</a>
                </div>
                <div class="section">
                    <?=qr('twitter')?>
                    <a href="https://twitter.com/RichinmeCom" class="ml7" target="_blank" rel="nofollow noopener">RichinmeCom</a>
                </div>
                <div class="section">
                    <?=qr('wechat')?>
                    <a href="weixin://dl/chat?perfilovstanislav" class="ml7" target="_blank" rel="nofollow noopener">PerfilovStanislav</a>
                </div>
                <div class="section">
                    <?=qr('weibo')?>
                    <a href="https://weibo.com/u/7304297481" class="ml7" target="_blank" rel="nofollow noopener">PerfilovStanislav</a>
                </div>
            </div>
        </div>


        <div class="panel heading-border panel-info">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="glyphicons glyphicons-message_out"></i><?=Translate()->writeMessage?>
                </span>
            </div>
            <div class="panel-body bg-light" id="<?=Views::FORM_SENT?>">
                <form method="post" action="/Contact/send">
                    <div class="section">
                        <label class="field prepend-icon">
                            <input name="name" class="gui-input onlyEn" autocomplete="off" placeholder="<?=Translate()->name?> (English only)">
                            <label class="field-icon">
                                <i class="fa fa-user"></i>
                            </label>
                        </label>
                    </div>
                    <div class="section description">
                        <label class="field prepend-icon">
                            <textarea class="gui-textarea" autocomplete="off" name="message" placeholder="<?=Translate()->message?>"></textarea>
                            <label class="field-icon">
                                <i class="fa fa-envelope-o"></i>
                            </label>
                        </label>
                    </div>
                    <div class="panel-footer text-right">
                        <button type="submit" class="button btn-primary"> <?=Translate()->sendForm?> </button>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </form>
            </div>
        </div>

    </div>
</div>