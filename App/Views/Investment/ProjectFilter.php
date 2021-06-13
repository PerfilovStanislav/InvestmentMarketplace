<?php
namespace App\Views\Investment; {
/**
 * @var ProjectFilter $this
 * @property Languages $languages
 * @property Language $pageLanguage
 * @property string $url
 * @property ShowRequest $request
 * @property integer $pagesCount
 */
Class ProjectFilter {} }

use App\Models\Collection\Languages;
use App\Models\MView\MVProjectFilterAvailableLang;
use App\Models\Table\{Language};
use App\Requests\Investment\ShowRequest;
?>
<div class="panel">
    <div class="panel-body">
        <div class="tab-content pn br-n">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle" aria-label="Language">
                    <span class="flag flag-<?=$this->pageLanguage->flag?>"></span>
                </button>
                <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                    <?php foreach ($this->languages as $lang): ?>
                        <li>
                            <a class="ajax page"
                               href="<?=$this->url.'/'.$this->request->getUriWithNewParam(['lang' => $lang['shortname']])?>">
                                <span class="flag flag-<?=$lang['flag']?> mr10"></span>
                                <?php printf('%s (%s) %d', $lang['name'], $lang['own_name'], $lang['cnt'])?>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>

                <div class="btn-group ml7">
                    <?php if ($this->pagesCount > 1): ?>
                    <?php foreach (range(1, min($this->pagesCount, 10)) as $page): ?>
                        <a href="<?=$this->url.'/'.$this->request->getUriWithNewParam(['page' => $page])?>" class="ajax page">
                            <div class="btn btn-sm ">
                                <span class="">
                                    <b><?=$page?></b>
                                </span>
                            </div>
                        </a>
                    <?php endforeach;?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
