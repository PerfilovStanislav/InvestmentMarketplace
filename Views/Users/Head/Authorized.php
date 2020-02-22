<?php
namespace Views\Users\Head; {
    /**
     * @var Authorized $this
     * @property User $user
     * @property Language[] $siteLanguages
     * @property string[] $selectedLanguage
     * @property LocaleInterface $locale
     * @property string $avatar
     */
Class Authorized {} }

use Interfaces\LocaleInterface;
use Models\Table\Language;
use Models\Table\User;
?>
<ul class="nav navbar-nav navbar-right">
    <li class="dropdown menu-merge">
        <div class="navbar-btn btn-group">
            <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                <span class="flag flag-<?=$this->siteLanguages->{$this->selectedLanguage}->flag?>"></span>
            </button>
            <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                <? foreach ($this->siteLanguages as $shortname => $language):?>
                    <li>
                        <a class="ajax <?=$shortname === $this->selectedLanguage ? 'selected' : ''?>"
                           href="/Users/changeLanguage/lang/<?=$shortname?>"
                           data-beforesend='{"f":["allClear"]}'>
                            <span class="flag flag-<?=$language->flag?> mr10"></span> <? printf('%s (%s)', $language->name, $language->own_name)?>
                        </a>
                    </li>
                <? endforeach;?>
            </ul>
        </div>
    </li>
    <li class="menu-divider hidden-xs">
        <i class="fa fa-circle"></i>
    </li>
    <li class="dropdown menu-merge">
        <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
            <img src="<?=$this->avatar?>" alt="avatar" class="mw30 br64">
            <span class="hidden-xs pl15"> <?=$this->user->name?> </span>
            <span class="caret caret-tp hidden-xs"></span>
        </a>
        <ul class="dropdown-menu list-group dropdown-persist w150" role="menu">
            <li class="dropdown-footer">
                <a href="/users/logout" class="ajax btn" data-beforesend='{"f":["allClear"]}'>
                    <span class="fa fa-power-off pr5"></span> <?=Translate()->exit?>
                </a>
            </li>
        </ul>
    </li>
</ul>