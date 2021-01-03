<?php
/**
 * @deprecated
 */
namespace App\Views\Users; { Class Login {} }
?>
<div class="tray tray-center">
    <div class="admin-form theme-primary mw800 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-primary">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="fa fa-pencil-square"></i><?=Translate()->enter?>
                </span>
            </div>
            <form method="post" action="/" id="user_form_authorization">
                <div class="panel-body bg-light">
                    <div class="section row">
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="login" class="gui-input onlyLogin" placeholder="<?=Translate()->login?>">
                                <label class="field-icon">
                                    <i class="fa fa-user"></i>
                                </label>
                            </label>
                            <em hidden class="state-error">ошибка</em>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="password" autocomplete="password" name="password" class="gui-input"
                                       placeholder="<?=Translate()->password?>"/>
                                <label class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                            <em hidden class="state-error">ошибка</em>
                        </div>
                        <div class="section">
                            <label class="switch block switch-success">
                                <input name="remember" id="remember" type="checkbox">
                                <label for="remember" data-on="Да" data-off="Нет"></label>
                                <span>Запомнить</span>
                            </label>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="button btn-primary"> <?=Translate()->enter?></button>
                        </div>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </div>
            </form>
        </div>
    </div>
</div>