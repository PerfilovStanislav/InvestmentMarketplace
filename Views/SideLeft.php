<?php
namespace Views; {
/**
 * @var SideLeft $this
 * @package Views
 * @property string[] $counts
 * @property bool $isAdmin
 */
Class SideLeft {}}
use Models\Constant\ProjectStatus;
?>
<div class="sidebar-left-content nano-content">
    <ul class="nav sidebar-menu">
        <li class="sidebar-label pt20"><?=Translate()->menu?></li>
        <li>
            <a href="/Investment/show/status/active" class="ajax page">
                <span class="fa fa-thumbs-o-up text-success-dark"></span>
                <span class="sidebar-title"><?=Translate()->active . ($this->counts[ProjectStatus::ACTIVE] ?? '')?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/show/status/not_published" class="ajax page">
                <span class="glyphicon glyphicon-time text-warning-dark"></span>
                <span class="sidebar-title"><?=Translate()->notPublished . ($this->counts[ProjectStatus::NOT_PUBLISHED] ?? '')?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/show/status/scam" class="ajax page">
                <span class="glyphicons glyphicons-skull text-danger-dark"></span>
                <span class="sidebar-title"><?=Translate()->scam . ($this->counts[ProjectStatus::DELETED] ?? '')?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <?php if ($this->isAdmin): ?>
            <li class="divider"></li>
            <li class="sidebar-label">АДМИН</li>
            <li>
                <a href="/Investment/show/status/paywait" class="ajax page">
                    <span class="glyphicon glyphicon-time"></span>
                    <span class="sidebar-title"><?=Translate()->paywait . ($this->counts[ProjectStatus::PAYWAIT] ?? ' 0')?></span>
                    <span class="sidebar-title-tray"></span>
                </a>
            </li>
            <li>
                <a href="/Investment/show/status/deleted" class="ajax page">
                    <span class="glyphicons glyphicons-remove_2"></span>
                    <span class="sidebar-title"><?=Translate()->deleted . ($this->counts[ProjectStatus::DELETED] ?? ' 0')?></span>
                    <span class="sidebar-title-tray"></span>
                </a>
            </li>
        <?php endif; ?>
        <li class="divider"></li>
        <li class="sidebar-label"><?=Translate()->contact?></li>
        <li>
            <a href="/Contact/show" class="ajax page">
                <span class="glyphicon glyphicon-book text-info-darker"></span>
                <span class="sidebar-title"><?=Translate()->contact?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li class="divider"></li>
        <span>
            <a href="/Investment/registration" class="ajax page">
                <div class="btn-type1 btn-type1-success" data-event="success">
                    <div class="btn-type1-icon">
                        <span class="fa fa-plus"></span>
                    </div>
                    <div class="btn-type1-text">
                        <b><?= Translate()->addProject ?></b>
                    </div>
                </div>
            </a>
        </span>
    </ul>
</div>