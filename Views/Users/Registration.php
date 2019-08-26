<?php
namespace Views\Users; { Class Registration {} }

use Models\Constant\DomElements;
?>
<div class="tray tray-center">
    <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-primary">
            <div class="panel-heading">
                    <span class="panel-title">
                      <i class="fa fa-pencil-square"></i><?=$this->locale['user_registration']?>
                    </span>
            </div>
            <form method="post" action="/" id="<?=DomElements::ADDUSER_FORM?>">
                <div class="panel-body bg-light">
                    <div class="section row" >
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="login" class="gui-input onlyEn" placeholder="<?=$this->locale['login']?>">
                                <label class="field-icon">
                                    <i class="fa fa-user"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="name" autocomplete="name" class="gui-input"
									   placeholder="<?=$this->locale['name']?>">
                                <label class="field-icon">
                                    <i class="fa fa-group"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="email" autocomplete="email" class="gui-input onlyEmail"
									   placeholder="<?=$this->locale['email']?>">
                                <label class="field-icon">
                                    <i class="fa fa-envelope-o"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="password" autocomplete="password" name="password" class="gui-input"
									   placeholder="<?=$this->locale['password']?>" />
                                <label class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="password" autocomplete="password" id="confirm_pass" class="gui-input"
									   placeholder="<?=$this->locale['repeat_password']?>" />
                                <label class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="button btn-primary"> <?=$this->locale['send_form']?> </button>
                        </div>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </div>
            </form>
        </div>
    </div>
</div>