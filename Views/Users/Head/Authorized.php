<?php
namespace Views\Users\Head\Authorized;
?>
<ul class="nav navbar-nav navbar-right">
  <li class="dropdown menu-merge">
    <div class="navbar-btn btn-group">
		<button data-toggle="dropdown" class="btn btn-sm dropdown-toggle">
			<span class="flag flag-<?=$this->availableLangs[$this->activeLang]['flag']?>"></span>
			<!-- <span class="caret"></span> -->
		</button>
		<ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
			<? foreach ($this->availableLangs as $shortname => $lang): ?>
				<li>
					<a class="ajax <?=$shortname===$this->activeLang ? 'selected' : ''?>"
					   href="/users/changeLanguage/lang/<?=$shortname?>"
					   data-beforesend='{"f":["allClear"]}'>
						<span class="flag flag-<?=$lang['flag']?> mr10"></span> <?printf('%s (%s)', $lang['name'], $lang['own_name'])?> </a>
				</li>
			<? endforeach; ?>
		</ul>
    </div>
  </li>
  <li class="menu-divider hidden-xs">
    <i class="fa fa-circle"></i>
  </li>
  <li class="dropdown menu-merge">
    <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
      <img src="<?=$this->photoThumb?>" alt="avatar" class="mw30 br64">
      <span class="hidden-xs pl15"> <?=$this->name?> </span>
      <span class="caret caret-tp hidden-xs"></span>
    </a>
    <ul class="dropdown-menu list-group dropdown-persist w150" role="menu">
      <li class="dropdown-footer">
        <a href="/users/logout" class="ajax btn" data-beforesend='{"f":["allClear"]}'>
			<span class="fa fa-power-off pr5"></span> Выйти
		</a>
      </li>
    </ul>
  </li>
</ul>