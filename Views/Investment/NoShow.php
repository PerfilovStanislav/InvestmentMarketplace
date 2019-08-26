<?php
namespace Views\Investment; {
/**
 * @var NoShow $this
 * @property LocaleInterface $locale
 * @property string|ProjectFilter $projectFilter
 */
Class NoShow {} }

use Interfaces\LocaleInterface;
?>
<div class="filters" id="projectfilter">
    <?=$this->projectFilter?>
</div>

<div class="tray tray-center">
    <div class="admin-form theme-primary center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-danger">
            <div class="panel-heading">
                <span class="panel-title">
                  <i class="fa fa-eye-slash"></i><?=$this->locale['no_project']?>
                </span>
            </div>
        </div>
    </div>
</div>
