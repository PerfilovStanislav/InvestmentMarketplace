<?php
namespace Views\Investment; {
/**
 * @var Show $this
 * @property Languages $languages
 * @property ProjectLangs $projectLangs
 * @property MVProjectLang[] $MVProjectLangs
 * @property Payment[] payments
 * @property Project[] $projects
 * @property AbstractLanguage $locale
 * @property bool $isAdmin
 * @property Language $pageLanguage
 */
Class Show {} }

use Helpers\Data\Currency;
use Helpers\Locales\AbstractLanguage;
use Libraries\Screens;
use Models\Collection\Languages;
use Models\Collection\ProjectLangs;
use Models\Constant\CurrencyType;
use Models\Constant\PlanPeriodType;
use Models\Constant\ProjectStatus;
use Models\Constant\Views;
use Models\MView\MVProjectLang;
use Models\Table\{Payment, Project, Language, ProjectLang};
?>
<a class="ajax page svg" href="/Contact/show">
    <object data="/assets/bnrs/bnr1.svg?<?=vsprintf('row1=%s&row2=%s', explode('|', sprintf(Translate()->placeBanner, 1)))?>" type="image/svg+xml" id="bnr1" ></object>
</a>

<div class="filters" id="<?=Views::PROJECT_FILTER?>">
    <?=$this->{Views::PROJECT_FILTER}?>
</div>

<div class="investment" itemscope itemtype="http://schema.org/OfferCatalog">
    <?php $isFirstRow = true; foreach ($this->projects as $project): ?>
        <div class="panel mb25 mt5" project_id="<?=$project->id?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">
            <?php /** @var ProjectLang $projectLang */ $projectLang = $this->projectLangs->getByKeyAndValue('project_id', $project->id);?>
            <meta itemprop="description" content="<?=str_replace(['< br>', '<br>', '>'], '', $projectLang->description)?>">
            <div class="panel-heading" itemprop="productID" content="<?=$project->id?>">
                <?php if ($this->isAdmin): ?>
                    <span>
                        <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                            <span class="fa fa-pencil"></span>
                        </button>
                        <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                            <li>
                                <?php foreach (array_diff(ProjectStatus::getValues(), [$project->status_id]) as $statusId): ?>
                                    <a class="ajax" href="/Investment/changeStatus/status/<?=ProjectStatus::getConstNameLower($statusId)?>/project/<?=$project->id?>">
                                        <?=ProjectStatus::getConstNameLower($statusId)?>
                                    </a>
                                <?php endforeach; ?>
                            </li>
                        </ul>
                    </span>

                    <span>
                        <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle btn-warning">
                            <span class="fa fa-image"></span>
                        </button>
                        <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu2">
                            <li>
                                <a class="ajax" href="/Investment/reloadScreen/project/<?=$project->id?>">
                                    Reload ScreenShot
                                </a>
                            </li>
                        </ul>
                    </span>
                <?php endif; ?>

                <a class="btn btn-details ajax page" href="/Investment/details/site/<?=$project->url?>/lang/<?=$this->pageLanguage->shortname?>">
                    <span class="fa fa-newspaper-o text-warning-dark"></span>
                </a>
                <span class="panel-title">
                    <a target="_blank" rel="nofollow noopener" itemprop="url" href="/Investment/redirect/project/<?=$project->id?>">
                        <span itemprop="name"><?=$project->name?></span>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                <div class="mbn flex inforow">
                    <div class="mnw270">
                        <div class="thumbnail" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                            <meta itemprop="description" content="<?=$project->name?>">
                            <span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                                <img src="/<?=$isFirstRow
                                    ? Screens::withTime(Screens::getJpgThumb($project->id))
                                    : Screens::withTime(Screens::getPreThumb($project->id))?>"
                                     alt="<?=$project->name?>"
                                     itemprop="image"
                                     class="media-object" href="<?=SITE.'/'.Screens::withTime(Screens::getOriginalJpgScreen($project->id))?>"
                                     <?=!$isFirstRow ? 'realthumb="/'. Screens::withTime(Screens::getThumb($project->id)) .'"' : ''?>
                                >
                            </span>
                        </div>
                    </div>
                    <div class="mnw200" style="flex: 16 0">
                        <div class="panel-heading lh30 h-30">
                            <span class="panel-icon">
                                <i class="fa fa-signal"></i>
                            </span>
                            <span class="panel-title"><?=Translate()->plans?></span>
                        </div>
                        <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                            <table class="table mbn justify">
                                <thead>
                                <tr>
                                    <th><?=Translate()->profit?></th>
                                    <th><?=Translate()->period?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($project->plan_percents as $key => $plan) {?>
                                    <tr>
                                        <td><?=$project->plan_percents[$key]?>%</td>
                                        <td><?=$project->plan_period[$key] . ' ' . Translate()->getPeriodName($project->plan_period_type[$key], $project->plan_period[$key])?></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mnw270" style="flex: 30 0">
                        <div class="panel-heading lh30 h-30">
                            <span class="panel-icon">
                                <i class="fa fa-gear"></i>
                            </span>
                            <span class="panel-title"><?=Translate()->options?></span>
                        </div>
                        <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                            <table class="table mbn tc-bold-last table-hover justify">
                                <tbody>
                                <tr>
                                    <td><?=Translate()->rating?></td>
                                    <td itemprop="productionDate" class="fw600">
                                        <?=$project->rating?>
                                        <div class="progress progress-bar-xs">
                                            <div class="progress-bar progress-bar-<?=[
                                                'danger', 'warning-dark', 'warning', 'success-light', 'success'
                                            ][(int)($project->rating/2)]?>" style="width: <?=$project->rating*10.0?>%;"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?=Translate()->dateStart?></td>
                                    <td itemprop="productionDate">
                                        <span class="fw600"><?=$project->start_date->format('Y-m-d')?></span>
                                        <span class="nowrap">
                                            (<?=$days = $project->start_date->diff(new \DateTime())->days?> <?=Translate()->getPeriodName(PlanPeriodType::DAY,$days)?>)
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?=Translate()->minDeposit?></td>
                                    <td itemprop="productionDate" class="fw600"><?=$project->min_deposit?> <span class="fa"><?=Currency::getCurrency()[$project->currency]['i']?></span></td>
                                </tr>
                                <tr>
                                    <td><?=Translate()->refProgram?></td>
                                    <td class="fw600"><?= implode('%, ', $project->ref_percent) . '%'?></td>
                                </tr>
                                <tr>
                                    <td><?=Translate()->languages?></td>
                                    <td><?php foreach ($this->MVProjectLangs->{$project->id}->lang_id as $langId): ;
                                            /** @var Language $lang */ $lang = $this->languages->{$langId};?>
                                            <i class="flag flag-<?=$lang->flag?>"
                                               title="<?=$lang->name . " ({$lang->own_name})"?>"></i>
                                        <?php endforeach;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?=Translate()->paymentSystem?>
                                    </td>
                                    <td><?php foreach ($project->id_payments as $paymentId):
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
                    <div class="mnw270" style="flex: 60 0">
                        <div class="panel-widget chat-widget">
                            <div class="panel-heading lh30 h-30">
                                <span class="panel-icon">
                                    <i class="fa fa-comments"></i>
                                </span>
                                <span class="panel-title"><?=Translate()->chat?></span>
                            </div>
                                <div class="panel-body bg-light dark panel-scroller scroller-lg pn mh-179">
                            </div>
                            <form class="admin-form chat-footer" chat_id="<?=$project->id?>"
                                  data-chat="<?=$project->id?>" autocomplete="off">
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
        </div>
    <?php $isFirstRow = false; endforeach;?>
</div>
