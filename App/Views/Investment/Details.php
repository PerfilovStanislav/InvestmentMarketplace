<?php
namespace App\Views\Investment; {
/**
 * @var Details $this
 * @property Project $project
 * @property ProjectLang $projectLang
 * @property AbstractLanguage $locale
 * @property Payment[] payments
 * @property Languages $languages
 */
Class Details {} }

use App\Helpers\Data\Currency;
use App\Helpers\Locales\AbstractLanguage;
use App\Libraries\Screens;
use App\Models\Collection\Languages;
use App\Models\Constant\PlanPeriodType;
use App\Models\Constant\ProjectStatus;
use App\Models\Table\{Payment, Project, Language, ProjectLang};
?>
<article>
<div class="tray tray-center" project_id="<?=$this->project->id?>">
    <div class="panel admin-form theme-primary mw1000 center-block">
        <div class="heading-border panel-<?=[
            ProjectStatus::ACTIVE        => 'success',
            ProjectStatus::PAYWAIT       => 'warning',
            ProjectStatus::NOT_PUBLISHED => 'info',
            ProjectStatus::SCAM          => 'danger',
            ProjectStatus::DELETED       => 'danger',
        ][$this->project->status_id] ?? 'default'?>">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="fa fa-newspaper-o"></i>
                    <a target="_blank" rel="nofollow noopener" itemprop="url" href="/Investment/redirect/project/<?=$this->project->id?>">
                        <span itemprop="name"><?=$this->project->name?></span>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="section original-photo">
                        <img src="/<?=Screens::getOriginalJpgScreen($this->project->id)?>"
                             alt="<?=$this->project->name?>"
                        >
                    </div>
                    <div class="section-divider mt40" id="spy7">
                        <span class="hide_for_iv"> <?=Translate()->description?> </span>
                    </div>
                    <div class="section">
                        <?=$this->projectLang->description?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel mw1000 center-block investment">
        <div class="panel-body">
            <div class="mbn flex inforow">
                <div class="mnw270" style="flex: 1 0">
                    <div class="panel-heading lh30 h-30">
                                <span class="panel-icon">
                                    <i class="fa fa-signal"></i>
                                </span>
                        <span class="panel-title hide_for_iv"><?=Translate()->plans?></span>
                    </div>
                    <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                        <table class="table mbn justify">
                            <thead>
                            <tr class="">
                                <th><?=Translate()->profit?></th>
                                <th><?=Translate()->period?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->project->plan_percents as $key => $plan) {?>
                                <tr>
                                    <td><?=$this->project->plan_percents[$key]?>%</td>
                                    <td><?=$this->project->plan_period[$key] . ' ' . Translate()->getPeriodName($this->project->plan_period_type[$key], $this->project->plan_period[$key])?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="mnw270" style="flex: 20 0">
                    <div class="panel-heading lh30 h-30">
                            <span class="panel-icon">
                                <i class="fa fa-gear"></i>
                            </span>
                        <span class="panel-title hide_for_iv"><?=Translate()->options?></span>
                    </div>
                    <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                        <table class="table mbn tc-bold-last table-hover justify">
                            <tbody>
                            <tr>
                                <td><?=Translate()->rating?></td>
                                <td itemprop="productionDate" class="fw600">
                                    <?=$this->project->rating?>
                                    <div class="progress progress-bar-xs">
                                        <div class="progress-bar progress-bar-<?=[
                                            'danger', 'warning-dark', 'warning', 'success-light', 'success'
                                        ][(int)($this->project->rating/2)]?>" style="width: <?=$this->project->rating*10.0?>%;"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?=Translate()->dateStart?></td>
                                <td itemprop="productionDate">
                                    <span class="fw600"><?=$this->project->start_date->format('Y-m-d')?></span>
                                    <span class="nowrap">
                                            (<?=$days = $this->project->start_date->diff(new \DateTime())->days?> <?=Translate()->getPeriodName(PlanPeriodType::DAY,$days)?>)
                                        </span>
                                </td>
                            </tr>
                            <tr>
                                <td><?=Translate()->minDeposit?></td>
                                <td itemprop="productionDate" class="fw600"><?=$this->project->min_deposit?> <span class="fa"><?=Currency::getCurrency()[$this->project->currency]['i']?></span></td>
                            </tr>
                            <tr>
                                <td><?=Translate()->refProgram?></td>
                                <td class="fw600"><?= implode('%, ', $this->project->ref_percent) . '%'?></td>
                            </tr>
                            <tr class="hide_for_iv">
                                <td><?=Translate()->languages?></td>
                                <td><?php foreach ($this->languages as $langId => $language):
                                        /** @var Language $language */ ?>
                                        <i class="flag flag-<?=$language->flag?>"
                                           title="<?=$language->name . " ({$language->own_name})"?>"></i>
                                    <?php endforeach;?>
                                </td>
                            </tr>
                            <tr class="hide_for_iv">
                                <td>
                                    <?=Translate()->paymentSystem?>
                                </td>
                                <td><?php foreach ($this->project->id_payments as $paymentId):
                                        /** @var Payment $payment*/ $payment = $this->payments->{$paymentId};
                                        ?>
                                        <i class="pay pay-<?=$payment->name?> mb10"
                                           title="<?=$payment->name?>"></i>
                                    <?php endforeach;?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel mw1000 center-block investment">
        <div class="panel-body">
            <div class="panel-widget chat-widget">
                <div class="panel-heading lh30 h-30">
                    <span class="panel-icon">
                        <i class="fa fa-comments"></i>
                    </span>
                    <span class="panel-title"><?=Translate()->chat?></span>
                </div>
                <div class="panel-body bg-light dark panel-scroller pn mh-500">
                </div>
                <form class="admin-form chat-footer" chat_id="<?=$this->project->id?>"
                      data-chat="<?=$this->project->id?>" autocomplete="off">
                    <label class="field prepend-icon">
                        <input name="message" class="gui-input"
                               placeholder="<?=Translate()->writeMessage?>">
                        <label class="field-icon">
                            <i class="fa fa-pencil"></i>
                        </label>
                        <div class="icon_send"></div>
                    </label>
                </form>
            </div>
        </div>
    </div>
</div>
</article>
