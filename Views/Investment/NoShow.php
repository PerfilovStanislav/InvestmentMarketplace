<?php
namespace Views\Investment; { final Class NoShow {} }
?>
<div class="filters">
    <div class="panel mb25 mt5">
        <div class="panel-body">
            <div class="tab-content pn br-n">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                        <span class="flag flag-<?=$this->flag?>"></span>
                    </button>
                    <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                        <? foreach ($this->filterLangs as $shortname => $lang):?>
                            <li>
                                <a class="ajax <?=$shortname === $this->filter['lang'] ? 'selected' : ''?> page"
                                   href="<?=$this->url.'/lang/'.$shortname?>">
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

<div class="tray tray-center">
    <div class="admin-form theme-primary center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-danger">
            <div class="panel-heading">
                <span class="panel-title">
                  <i class="fa fa-eye-slash"></i><?=$this->locale['no_project']?>
                </span>
            </div>
        </div>
    </div>
</div>
