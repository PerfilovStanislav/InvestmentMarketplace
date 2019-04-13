<?php
namespace Views;
?>
<div class="sidebar-left-content nano-content">
    <ul class="nav sidebar-menu">
        <li class="sidebar-label pt20"><?=$this->locale['menu']?></li>
        <li>
            <a href="/Investment/show/status/active" class="ajax page">
                <span class="glyphicon glyphicon-fire text-warning-dark"></span>
                <span class="sidebar-title"><?=$this->locale['active']?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/show/status/not_published" class="ajax page">
                <span class="fa fa-pause"></span>
                <span class="sidebar-title"><?=$this->locale['not_published']?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/registration" class="ajax">
                <span class="fa fa-plus text-success"></span>
                <span class="sidebar-title"><?=$this->locale['add_project']?></span>

                <span class="sidebar-title-tray"></span>
            </a>
        </li>
    </ul>
</div>