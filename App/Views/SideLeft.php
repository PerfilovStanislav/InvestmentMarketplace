<?php
namespace App\Views; {
/**
 * @var SideLeft $this
 * @package App\Views
 * @property string[] $counts
 * @property bool $isAdmin
 * @property array $banners
 */
Class SideLeft {}}
use App\Models\Constant\ProjectStatus;
?>
<div class="sidebar-left-content nano-content">
    <ul class="nav sidebar-menu">
        <li class="sidebar-label pt20"><?=Translate()->projects?></li>
        <li>
            <a href="/Investment/show/status/active" class="ajax page scrollup">
                <span class="fa fa-thumbs-o-up text-success-dark"></span>
                <span class="sidebar-title"><?=Translate()->active . ($this->counts[ProjectStatus::ACTIVE] ?? '')?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/show/status/not_published" class="ajax page scrollup">
                <span class="glyphicons glyphicons-alarm text-warning-dark"></span>
                <span class="sidebar-title"><?=Translate()->notPublished . ($this->counts[ProjectStatus::NOT_PUBLISHED] ?? '')?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Investment/show/status/scam" class="ajax page scrollup">
                <span class="glyphicons glyphicons-skull text-danger-dark"></span>
                <span class="sidebar-title"><?=Translate()->scam . ($this->counts[ProjectStatus::SCAM] ?? '')?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="/Investment/registration" class="ajax page scrollup">
                <span class="fa fa-plus text-success-dark"></span>
                <span class="sidebar-title"><?=Translate()->addProject?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <?php if ($this->isAdmin): ?>
            <li class="divider"></li>
            <li class="sidebar-label">АДМИН</li>
            <li>
                <a href="/Investment/show/status/paywait" class="ajax page scrollup">
                    <span class="glyphicons glyphicons-clock"></span>
                    <span class="sidebar-title"><?=Translate()->paywait . ($this->counts[ProjectStatus::PAYWAIT] ?? ' 0')?></span>
                    <span class="sidebar-title-tray"></span>
                </a>
            </li>
            <li>
                <a href="/Investment/show/status/deleted" class="ajax page scrollup">
                    <span class="glyphicons glyphicons-remove_2"></span>
                    <span class="sidebar-title"><?=Translate()->deleted . ($this->counts[ProjectStatus::DELETED] ?? ' 0')?></span>
                    <span class="sidebar-title-tray"></span>
                </a>
            </li>
        <?php endif; ?>
        <li class="divider"></li>
        <li class="sidebar-label"><?=Translate()->menu?></li>
        <li>
            <a href="/Contact/show" class="ajax page scrollup">
                <span class="glyphicons glyphicons-book text-info-darker"></span>
                <span class="sidebar-title"><?=Translate()->contact?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li>
            <a href="/Purchase/banners" class="ajax page scrollup">
                <span class="fa fa-bullhorn"></span>
                <span class="sidebar-title"><?=Translate()->advertising?></span>
                <span class="sidebar-title-tray"></span>
            </a>
        </li>
        <li class="divider"></li>
        <?php $h = count($this->banners) * 135 + 5; ?>
        <div class="bnrs bnrs_left" style="height: <?=$h?>px;">
            <?php foreach ($this->banners as $i => $banner): ?>
                <span id="bnrs_<?=$i?>">
                    <a class="svg bnr_top" href="/purchase/banners" target="_blank" rel="noreferrer">
                        <img class="bnr_left" src="/assets/bnrs/empty2.jpg" alt="ad">
                    </a>
                </span>
            <?php endforeach; ?>
        </div>
    </ul>
</div>