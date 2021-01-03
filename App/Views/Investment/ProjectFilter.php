<?php
namespace App\Views\Investment; {
/**
 * @var ProjectFilter $this
 * @property MVProjectFilterAvailableLang[] $MVProjectFilterAvailableLangs
 * @property Languages $languages
 * @property Language $pageLanguage
 * @property string $url
 * @property ShowRequest $request
 */
Class ProjectFilter {} }

use App\Models\Collection\Languages;
use App\Models\MView\MVProjectFilterAvailableLang;
use App\Models\Table\{Language};
use App\Requests\Investment\ShowRequest;
?>
<div class="panel mb25 mt5">
    <div class="panel-body">
        <div class="tab-content pn br-n">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                    <span class="flag flag-<?=$this->pageLanguage->flag?>"></span>
                </button>
                <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                    <?php foreach ($this->MVProjectFilterAvailableLangs as $MVProjectFilterAvailableLang):
                        /** @var Language $lang */$lang = $this->languages->{$MVProjectFilterAvailableLang->lang_id};
                        ?>
                        <li>
                            <a class="ajax page"
                               href="<?=$this->url.'/'.$this->request->getUriWithNewParam(['lang' => $lang->shortname])?>">
                                <span class="flag flag-<?=$lang->flag?> mr10"></span>
                                <?php printf('%s (%s) %d', $lang->name, $lang->own_name, $MVProjectFilterAvailableLang->cnt)?>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>
