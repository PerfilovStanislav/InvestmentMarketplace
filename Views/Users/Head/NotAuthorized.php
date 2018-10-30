<ul class="nav navbar-nav navbar-right">
  <li class="dropdown menu-merge">
    <div class="navbar-btn btn-group">
      <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
        <span class="flag-xs flag-us"></span>
        <!-- <span class="caret"></span> -->
      </button>
      <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
        <li>
          <a href="javascript:void(0);">
            <span class="flag-xs flag-in mr10"></span> Hindu </a>
        </li>
        <li>
          <a href="javascript:void(0);">
            <span class="flag-xs flag-tr mr10"></span> Turkish </a>
        </li>
        <li>
          <a href="javascript:void(0);">
            <span class="flag-xs flag-es mr10"></span> Spanish </a>
        </li>
      </ul>
    </div>
  </li>
  <li class="menu-divider hidden-xs">
    <i class="fa fa-circle"></i>
  </li>
  <li class="dropdown menu-merge">
    <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
      <img src="/assets/img/avatars/1.jpg" alt="avatar" class="mw30 br64">
      <span class="hidden-xs pl15"> Гость </span>
      <span class="caret caret-tp hidden-xs"></span>
    </a>
    <ul class="dropdown-menu list-group dropdown-persist w350" role="menu">
      <li class="dropdown-header clearfix">
        <div class="admin-form theme-primary w300 center-block">


          <form method="post" action="/" id="authorizationuser_form">
              <div class="section row mb5">
                <label class="field prepend-icon">
                  <input placeholder="<?=$this->locale['login']?> <?=$this->locale['or']?>
                  <?=$this->locale['email']?>" class="gui-input onlyEmail" autocomplete="login" name="login">
                  <input type="hidden" name="ajax" value="1">
                  <label class="field-icon">
                    <i class="glyphicons glyphicons-user"></i>
                  </label>
                </label>
              </div>



              <div class="section row mb5">
                <label class="field prepend-icon">
                  <input placeholder="Пароль" class="gui-input" autocomplete="password" name="password" type="password" />
                  <label class="field-icon">
                    <i class="fa fa-lock"></i>
                  </label>
                </label>
              </div>



              <div class="section row mt10 mb5">
                  <label class="switch block switch-success">
                      <input name="remember" id="remember" type="checkbox">
                      <label for="remember" data-on="<?=$this->locale['yes']?>" data-off="<?=$this->locale['no']?>"></label>
                      <span><?=$this->locale['remember']?></span>
                  </label>
              </div>

              <div class="section row mbn">
                <div class="pull-left">
                  <button type="submit" class="btn  btn-gradient btn-info btn-block w125" ><?=$this->locale['enter']?></button>
                </div>

                <div class="pull-right">
                  <a href="/users/registration" class="btn ajax page btn-gradient btn-success btn-block w125"
				  ><?=$this->locale['registration']?></a>
                </div>
              </div>
            </form>
        </div>
      </li>
    </ul>
  </li>
</ul>