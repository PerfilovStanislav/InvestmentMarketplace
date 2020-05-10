<?php
namespace Views\Users\Head; {
    /**
     * @var NotAuthorized $this
     * @property Language[] $siteLanguages
     * @property string[] $selectedLanguage
     * @property string $avatar
     */
Class NotAuthorized {} }

use Interfaces\LocaleInterface;
use Models\Constant\DomElements;
use Models\Table\Language;
?>
<ul class="nav navbar-nav navbar-right">
    <li class="dropdown menu-merge">
        <div class="navbar-btn btn-group">
            <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
                <span class="flag flag-<?=$this->siteLanguages->{$this->selectedLanguage}->flag?>"></span>
            </button>
            <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                <?php foreach ($this->siteLanguages as $shortname => $language):?>
                    <li>
                        <a class="ajax <?=$shortname === $this->selectedLanguage ? 'selected' : ''?>"
                           href="/Users/changeLanguage/lang/<?=$shortname?>"
                           rel="nofollow noopener" >
                            <span class="flag flag-<?=$language->flag?> mr10"></span> <?php printf('%s (%s)', $language->name, $language->own_name)?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </li>
    <li class="menu-divider hidden-xs">
        <i class="fa fa-circle"></i>
    </li>
    <li class="dropdown menu-merge">
        <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
            <img src="<?=$this->avatar?>" alt="avatar" class="mw30 br64">
            <span class="hidden-xs pl15"> <?=Translate()->guest?> </span>
            <span class="caret caret-tp hidden-xs"></span>
        </a>
        <ul class="dropdown-menu list-group dropdown-persist w350" role="menu">
            <li class="dropdown-header clearfix">
                <div class="admin-form theme-primary w300 center-block">
                    <form method="post" action="/Users/authorize" id="<?=DomElements::AUTHORIZATION_USER_FORM?>">
                        <div class="section row mb5">
                            <label class="field prepend-icon">
                                <input placeholder="<?=Translate()->login?>"
                                   class="gui-input onlyLogin" autocomplete="login" name="login">
                                <input type="hidden" name="ajax" value="1">
                                <label class="field-icon">
                                    <i class="glyphicons glyphicons-user"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section row mb5">
                            <label class="field prepend-icon">
                                <input placeholder="<?=Translate()->password?>" class="gui-input" autocomplete="password" name="password"
                                       type="password"/>
                                <label class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section row mt10 mb5">
                            <label class="switch block switch-success">
                                <input name="remember" id="remember" type="checkbox">
                                <label for="remember" data-on="<?=Translate()->yes?>"
                                       data-off="<?=Translate()->no?>"></label>
                                <span><?=Translate()->remember?></span>
                            </label>
                        </div>
                        <div class="section row mbn">
                            <div class="pull-left">
                                <button type="submit"
                                        class="btn  btn-gradient btn-info btn-block w125"><?=Translate()->enter?></button>
                            </div>
                            <div class="pull-right">
                                <a href="/users/registration"
                                   class="btn ajax page btn-gradient btn-success btn-block w125"
                                ><?=Translate()->registration?></a>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
        </ul>
    </li>
</ul>