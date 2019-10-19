<?php
namespace Views\Investment; {
/**
 * @var Show $this
 * @property Languages $languages
 * @property ProjectLangs $projectLangs
 * @property MVProjectLang[] $MVProjectLangs
 * @property Payment[] payments
 * @property Project[] $projects
 * @property LocaleInterface $locale
 * @property string|ProjectFilter $projectFilter
 * @property bool $isAdmin
 */
Class Show {} }

use Helpers\Data\Currency;
use Interfaces\LocaleInterface;
use Libraries\File;
use Models\Collection\Languages;
use Models\Collection\ProjectLangs;
use Models\Constant\ProjectStatus;
use Models\Constant\Views;
use Models\MView\MVProjectLang;
use Models\Table\{Payment, Project, Language, ProjectLang};
?>
<div class="filters" id="<?=Views::PROJECT_FILTER?>">
    <?=$this->{Views::PROJECT_FILTER}?>
</div>

<div class="investment">
    <? $isFirstRow = true; foreach ($this->projects as $project): ?>
        <div class="panel mb25 mt5" project_id="<?=$project->id?>">
            <div class="panel-heading">
                <?php if ($this->isAdmin): ?>
                    <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                        <span class="fa fa-pencil"></span>
                    </button>
                    <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                        <li>
                            <?php foreach (array_diff(ProjectStatus::getValues(), [$project->status_id]) as $statusId): ?>
                                <a class="ajax" href="/Investment/changeStatus/status/<?=ProjectStatus::getConstName($statusId)?>/project/<?=$project->id?>">
                                    <?=ProjectStatus::getConstName($statusId)?>
                                </a>
                            <?php endforeach; ?>
                        </li>
                    </ul>
                <?php endif; ?>

                <span class="panel-title">
                    <a target="_blank" rel="nofollow noopener" href="/Investment/redirect/project/<?=$project->id?>"><?=$project->name?></a>
                </span>
                <ul class="nav panel-tabs-border panel-tabs">
                    <li class="active">
                        <a href="#main_<?=$project->id?>" data-toggle="tab"><?=$this->locale['general']?></a>
                    </li>
                    <li>
                        <a href="#description_<?=$project->id?>"
                           data-toggle="tab"><?=$this->locale['description']?></a>
                    </li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content pn br-n">
                    <div id="main_<?=$project->id?>" class="tab-pane active">
                        <div class="mbn flex inforow">
                            <div class="mnw270">
                                <div class="thumbnail">
                                    <img src="/<?=$isFirstRow ? File::getJpgThumb($project->id) : File::getPreThumb($project->id)?>"
                                         alt="<?=$project->name?>"
                                         class="media-object" href="/<?=File::getOriginalScreen($project->id)?>"
                                         <?=!$isFirstRow ? 'realthumb="/'. File::getThumb($project->id) .'"' : ''?>
                                    >
                                </div>
                            </div>
                            <div class="mnw270" style="flex: 22 0">
                                <div class="panel-heading lh30 h-30">
                                    <span class="panel-title"><?=$this->locale['plans']?></span>
                                </div>
                                <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                                    <table class="table mbn justify">
                                        <thead>
                                        <tr class="">
                                            <th><?=$this->locale['profit']?></th>
                                            <th><?=$this->locale['period']?></th>
                                            <th><?=$this->locale['deposit']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($project->plan_percents as $key => $plan) {?>
                                            <tr>
                                                <td><?=$project->plan_percents[$key]?>%</td>
                                                <td><?=$project->plan_period[$key] . ' ' . \Helpers\Locale::getPeriodName($project->plan_period_type[$key], $project->plan_period[$key])?></td>
                                                <td><?=$project->plan_start_deposit[$key]?>
                                                    <span class="fa"><?=Currency::getCurrency()[$project->plan_currency_type[$key]]['i']?></span>
                                                </td>
                                            </tr>
                                        <? }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="mnw270" style="flex: 30 0">
                                <div class="panel-heading lh30 h-30">
                                    <span class="panel-title"><?=$this->locale['options']?></span>
                                </div>
                                <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                                    <table class="table mbn tc-bold-last table-hover justify">
                                        <tbody>
                                        <tr>
                                            <td><?=$this->locale['ref_program']?></td>
                                            <td><?= implode('%, ', $project->ref_percent) . '%'?></td>
                                        </tr>
                                        <tr>
                                            <td><?=$this->locale['languages']?></td>
                                            <td><? foreach ($this->MVProjectLangs->{$project->id}->lang_id as $langId): ;
                                                    /** @var Language $lang */ $lang = $this->languages->{$langId};?>
                                                    <i class="flag flag-<?=$lang->flag?>"
                                                       title="<?=$lang->name . " ({$lang->own_name})"?>"></i>
                                                <? endforeach;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?=$this->locale['payment_system']?>
                                            </td>
                                            <td><? foreach ($project->id_payments as $paymentId):
                                                    /** @var Payment $payment*/ $payment = $this->payments->{$paymentId};
                                                    ?>
                                                    <i class="pay pay-<?=$payment->name?> mb10"
                                                       title="<?=$payment->name?>"></i>
                                                <? endforeach;?>
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
                                    <i class="fa fa-pencil"></i>
                                </span>
                                        <span class="panel-title"><?=$this->locale['chat']?></span>
                                    </div>
                                    <div class="panel-body bg-light dark panel-scroller scroller-lg pn mh-179">
                                    </div>
                                    <form class="admin-form chat-footer" chat_id="<?=$project->id?>"
                                          data-chat="<?=$project->id?>" autocomplete="off">
                                        <label class="field prepend-icon">
                                            <input name="message" class="gui-input"
                                                   placeholder="<?=$this->locale['write_message']?>">
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
                    <div id="description_<?=$project->id?>" class="tab-pane">
                        <div class="mbn flex inforow">

                            <div class="mnw270">
                                <div class="thumbnail">
                                    <img src="/<?=$isFirstRow ? File::getJpgThumb($project->id) : File::getPreThumb($project->id)?>"
                                         class="media-object" href="/<?=File::getOriginalScreen($project->id)?>"
                                        <?=!$isFirstRow ? 'realthumb="/'. File::getThumb($project->id) .'"' : ''?>
                                    >
                                </div>
                            </div>

                            <div class="mnw220" style="flex: 22 0">
                                <div class="panel-heading lh30 h-30">
                                    <span class="panel-title"><?=$this->locale['description']?></span>
                                </div>
                                <div class="panel-body panel-scroller scroller-xs scroller-active scroller-success mih-220 scroller-content">
                                    <? /** @var ProjectLang $projectLang */ $projectLang = $this->projectLangs->getByKeyAndValue('project_id', $project->id);?>
                                    <?= $projectLang->description?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? $isFirstRow = false; endforeach;?>
</div>
