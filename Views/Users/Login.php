<?php
namespace Views\Users\Login;
?>
<div class="tray tray-center">
    <div class="admin-form theme-primary mw500 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-primary">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="fa fa-pencil-square"></i><?=$this->user_authorization?>
                </span>
            </div>
            <form method="post" action="/" id="user_form_authorization">
                <div class="panel-body bg-light">
                    <div class="section row">
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="login" class="gui-input onlyEmail" placeholder="<?=$this->Login?>">
                                <label class="field-icon">
                                    <i class="fa fa-user"></i>
                                </label>
                            </label>
                            <em hidden class="state-error">ошибка</em>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="password" autocomplete="password" name="password" class="gui-input"
                                       placeholder="<?=$this->Password?>"/>
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
                            <button type="submit" class="button btn-primary"> <?=$this->locale['enter']?></button>
                        </div>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </div>
            </form>
        </div>
    </div>
</div>