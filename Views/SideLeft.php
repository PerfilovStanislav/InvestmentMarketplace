<?php
namespace Views; { Class SideLeft {} }
?>
<div class="sidebar-left-content nano-content">
    <ul class="nav sidebar-menu">
        <li class="sidebar-label pt20"><?=Translate()->menu?></li>
        <li>
            <a href="/Investment/show/status/active" class="ajax page">
                <span class="glyphicon glyphicon-fire text-warning-dark"></span>
                <span class="sidebar-title"><?=Translate()->active?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/show/status/not_published" class="ajax page">
                <span class="fa fa-pause"></span>
                <span class="sidebar-title"><?=Translate()->notPublished?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/registration" class="ajax page">
                <span class="fa fa-plus text-success"></span>
                <span class="sidebar-title"><?=Translate()->addProject?></span>

                <span class="sidebar-title-tray"></span>
            </a>
        </li>
    </ul>
</div>