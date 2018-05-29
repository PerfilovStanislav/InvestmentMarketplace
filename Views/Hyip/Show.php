<div class="hyip">
<? foreach ($this->projects as $project_id => $project): ?>
<div class="panel mb25 mt5">
    <div class="panel-heading">
        <span class="panel-title hidden-xs"> <?=$project['name']?></span>
        <ul class="nav panel-tabs-border panel-tabs">
            <li class="active">
                <a href="ecommerce_products.html#tab1_1" data-toggle="tab">General</a>
            </li>
            <li>
                <a href="ecommerce_products.html#tab1_2" data-toggle="tab">Description</a>
            </li>
        </ul>
    </div>
    <div class="panel-body p10">
        <div class="tab-content pn br-n">
            <div id="tab1_1" class="tab-pane active">
                <div class="mbn flex inforow">

                    <div class="" style="flex: 0 0">
                        <img src="/<?=$project['file_name']?>_th.jpg" class="media-object thumbnail">
                    </div>

                    <div class="mnw220" style="flex: 22 0">
                        <div class="panel-heading lh30 h-30">
                            <span class="panel-title"><?=$this->locale['plans']?></span>
                        </div>
                        <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                            <table class="table mbn justify" >
                                <thead>
                                    <tr class="">
                                        <th><?=$this->locale['profit']?></th>
                                        <th><?=$this->locale['period']?></th>
                                        <th><?=$this->locale['deposit']?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($this->plans[$project_id]['plan'] as $plan) { ?>
                                    <tr>
                                        <td><?=$plan[0]?>%</td>
                                        <td><?=$plan[1].' '.\Helpers\Locale::getPeriodName($plan[2],$plan[1])?></td>
                                        <td><?=$plan[3]?><span class="fa"><?=$this->currency[$plan[4]-1]['i']?></span></td>
                                    </tr>
                                <? } ?>
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
                                    <td><?=implode('%, ', $project['ref_percent']).'%'?></td>
                                </tr>
                                <tr>
                                    <td><?=$this->locale['languages']?></td>
                                    <td><?foreach ($this->flags[$project_id]['lang_id'] as $fl):?>
                                            <i class="flag flag-<?=($a=$this->languages[$fl])['flag']?>" title="<?=$a['name']." ({$a['own_name']})"?>"></i>
                                        <?endforeach;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?=$this->locale['payment_system']?>
                                    </td>
                                    <td><?foreach ($project['id_payments'] as $pay):?>
                                            <i class="pay pay-<?=$a=$this->payments[$pay]['name']?> mb10" title="<?=$a?>"></i>
                                        <?endforeach;?>
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
                                <div class="media">
                                    <div class="media-left">
                                        <a href="widgets_panel.html#">
                                            <img class="media-object" alt="64x64" src="/assets/img/avatars/2.jpg">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <span class="media-status"></span>
                                        <h5 class="media-heading">Courtney Faught
                                            <small> - 12:30am</small>
                                        </h5> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.ibero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.ibero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.ibero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.ibero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.ibero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <span class="media-status offline"></span>
                                        <h5 class="media-heading">Joe Gibbons
                                            <small> - 12:30am</small>
                                        </h5> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.
                                    </div>
                                    <div class="media-right">
                                        <a href="widgets_panel.html#">
                                            <img class="media-object" alt="64x64" src="/assets/img/avatars/1.jpg">
                                        </a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="widgets_panel.html#">
                                            <img class="media-object" alt="64x64" src="/assets/img/avatars/2.jpg">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <span class="media-status online"></span>
                                        <h5 class="media-heading">Courtney Faught
                                            <small> - 12:30am</small>
                                        </h5> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.  qwrfedgbfh qwrfedgbfh qwrfedgbfh
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <span class="media-status offline"></span>
                                        <h5 class="media-heading">Joe Gibbons
                                            <small> - 12:30am</small>
                                        </h5> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.
                                    </div>
                                    <div class="media-right">
                                        <a href="widgets_panel.html#">
                                            <img class="media-object" alt="64x64" src="/assets/img/avatars/1.jpg">
                                        </a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="widgets_panel.html#">
                                            <img class="media-object" alt="64x64" src="/assets/img/avatars/2.jpg">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <span class="media-status online"></span>
                                        <h5 class="media-heading">Courtney Faught
                                            <small> - 12:30am</small>
                                        </h5> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <span class="media-status offline"></span>
                                        <h5 class="media-heading">Joe Gibbons
                                            <small> - 12:30am</small>
                                        </h5> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.
                                    </div>
                                    <div class="media-right">
                                        <a href="widgets_panel.html#">
                                            <img class="media-object" alt="64x64" src="/assets/img/avatars/1.jpg">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-form chat-footer">
                                <label class="field prepend-icon">
                                    <input name="projectname" class="gui-input onlyText" placeholder="<?=$this->locale['write_message']?>">
                                    <label class="field-icon">
                                        <i class="fa fa-pencil"></i>
                                    </label>
                                    <div class="icon_send"></i></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!--<div class="pl15 fl  admin-form" style="width: calc(100% - 850px)">
                        <div class="section mb10">
                            <label for="name2" class="field prepend-icon">
                                <input type="text" name="name2" id="name2" class="event-name gui-input br-light light" placeholder="Product Title">
                                <label for="name2" class="field-icon">
                                    <i class="fa fa-tag"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section mb10">
                            <label class="field prepend-icon">
                                <textarea style="height: 160px;" class="gui-textarea br-light bg-light" id="comment" name="comment" placeholder="Product Description"></textarea>
                                <label for="comment" class="field-icon">
                                    <i class="fa fa-comments"></i>
                                </label>
                                <span class="input-footer hidden">
                                       <strong>Hint:</strong>Don't be negative or off topic! just be awesome...</span>
                            </label>
                        </div>
                    </div>-->
                </div>
            </div>
            <div id="tab1_2" class="tab-pane">
                <div class="section row">
                </div>
            </div>
        </div>
    </div>
</div>
<? endforeach; ?>
</div>
