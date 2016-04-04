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
      <img src="<?=SITE;?>assets/img/avatars/1.jpg" alt="avatar" class="mw30 br64">
      <span class="hidden-xs pl15"> Гость </span>
      <span class="caret caret-tp hidden-xs"></span>
    </a>
    <ul class="dropdown-menu list-group dropdown-persist w350" role="menu">
      <li class="dropdown-header clearfix">
        <div class="admin-form theme-primary w300 center-block">


          <div class="section row mb5">
            <label class="field prepend-icon">
              <input placeholder="Логин или Email" class="gui-input onlyText" name="login">
              <label class="field-icon">
                <i class="glyphicons glyphicons-user"></i>
              </label>
            </label>
          </div>



          <div class="section row mb5">
            <label class="field prepend-icon">
              <input placeholder="Пароль" class="gui-input onlyText" name="password" type="password">
              <label class="field-icon">
                <i class="fa fa-lock"></i>
              </label>
            </label>
          </div>



          <div class="section row mbn">
            <div class="pull-left">
              <a class="btn  btn-gradient btn-info btn-block w125" id="login">Вход</a></div>

            <div class="pull-right">
              <a href="<?=SITE;?>Users/registration" class="btn  btn-gradient btn-success btn-block w125" id="userReg" >Регистрация</a>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </li>
</ul>