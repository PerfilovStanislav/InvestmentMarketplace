<?php
namespace Views\Investment\Show;
/** @see \Controllers\Investment::show() */
?>
<div class="filters">
    <div class="panel mb25 mt5">
        <div class="panel-body p10">
            <div class="tab-content pn br-n">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                        <span class="flag flag-<?=$this->filterLangs[$this->filter['lang']]['flag']?>"></span>
                    </button>
                    <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                        <? foreach ($this->filterLangs as $shortname => $lang):?>
                            <li>
                                <a class="ajax <?=$shortname === $this->filter['lang'] ? 'selected' : ''?> page"
                                   data-beforesend='{"document":{"changePageLang":"<?=$shortname?>"}}'>
                                    <span class="flag flag-<?=$lang['flag']?> mr10"></span> <? printf('%s (%s)', $lang['name'], $lang['own_name'])?>
                                </a>
                            </li>
                        <? endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="investment">
    <? foreach ($this->projects as $project_id => $project):?>
        <div class="panel mb25 mt5" project_id="<?=$project_id?>">
            <div class="panel-heading">
                <span class="panel-title hidden-xs"> <?=$project['name']?></span>
                <ul class="nav panel-tabs-border panel-tabs">
                    <li class="active">
                        <a href="#main_<?=$project_id?>" data-toggle="tab"><?=$this->locale['general']?></a>
                    </li>
                    <li>
                        <a href="#description_<?=$project_id?>"
                           data-toggle="tab"><?=$this->locale['description']?></a>
                    </li>
                </ul>
            </div>
            <div class="panel-body p10">
                <div class="tab-content pn br-n">
                    <div id="main_<?=$project_id?>" class="tab-pane active">
                        <div class="mbn flex inforow">

                            <div class="" style="flex: 0 0">
                                <img src="/<?=$project['file_name']?>_th.jpg" class="media-object thumbnail" href="/<?=$project['file_name']?>.jpg">
                            </div>

                            <div class="mnw220" style="flex: 22 0">
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
                                        <?php foreach ($this->plans[$project_id]['plan'] as $plan) {?>
                                            <tr>
                                                <td><?=$plan[0]?>%</td>
                                                <td><?=$plan[1] . ' ' . \Helpers\Locale::getPeriodName($plan[2], $plan[1])?></td>
                                                <td><?=$plan[3]?><span
                                                            class="fa"><?=$this->currency[$plan[4] - 1]['i']?></span>
                                                </td>
                                            </tr>
                                        <? }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="mnw300" style="flex: 30 0">
                                <div class="panel-heading lh30 h-30">
                                    <span class="panel-title"><?=$this->locale['options']?></span>
                                </div>
                                <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                                    <table class="table mbn tc-bold-last table-hover justify">
                                        <tbody>
                                        <tr>
                                            <td><?=$this->locale['ref_program']?></td>
                                            <td><?= implode('%, ', $project['ref_percent']) . '%'?></td>
                                        </tr>
                                        <tr>
                                            <td><?=$this->locale['languages']?></td>
                                            <td><? foreach ($this->projectLangs[$project_id]['lang_id'] as $fl):?>
                                                    <i class="flag flag-<?= ($a = $this->languages[$fl])['flag']?>"
                                                       title="<?=$a['name'] . " ({$a['own_name']})"?>"></i>
                                                <? endforeach;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?=$this->locale['payment_system']?>
                                            </td>
                                            <td><? foreach ($project['id_payments'] as $pay):?>
                                                    <i class="pay pay-<?=$a = $this->payments[$pay]['name']?> mb10"
                                                       title="<?=$a?>"></i>
                                                <? endforeach;?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="mnw400" style="flex: 60 0"> <!--style="width: calc(100% - 889px);"-->
                                <div class="panel-widget chat-widget">
                                    <div class="panel-heading lh30 h-30">
                                <span class="panel-icon">
                                    <i class="fa fa-pencil"></i>
                                </span>
                                        <span class="panel-title"><?=$this->locale['chat']?></span>
                                    </div>
                                    <div class="panel-body bg-light dark panel-scroller scroller-lg pn mh-179">
                                        <!--                                --><? //=$this->chats[$project_id]??''?>
                                    </div>
                                    <form class="admin-form chat-footer" chat_id="<?=$project_id?>"
                                          data-chat="<?=$project_id?>" autocomplete="off">
                                        <label class="field prepend-icon">
                                            <input name="message" class="gui-input"
                                                   placeholder="<?=$this->locale['write_message']?>">
                                            <label class="field-icon">
                                                <i class="fa fa-pencil"></i>
                                            </label>
                                            <div class="icon_send"></i></div>
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="description_<?=$project_id?>" class="tab-pane">
                        <div class="mbn flex inforow">

                            <div class="" style="flex: 0 0">
                                <img src="/<?=$project['file_name']?>_th.jpg" class="media-object thumbnail">
                            </div>

                            <div class="mnw220" style="flex: 22 0">
                                <div class="panel-heading lh30 h-30">
                                    <span class="panel-title"><?=$this->locale['description']?></span>
                                </div>
                                <div class="panel-body panel-scroller scroller-xs scroller-active scroller-success mih-220 scroller-content">
                                    <?=$project['description']?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endforeach;?>
</div>
