<?php
namespace Views\Investment; {
/**
 * @var NoShow $this
 * @property string|ProjectFilter $projectFilter
 */
Class NoShow {} }

use Interfaces\LocaleInterface;
use Models\Constant\Views;
?>
<div class="filters" id="<?=Views::PROJECT_FILTER?>">
    <?=$this->{Views::PROJECT_FILTER}?>
</div>

<div class="tray tray-center">
    <div class="admin-form theme-primary center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-danger">
            <div class="panel-heading">
                <span class="panel-title">
                  <i class="fa fa-eye-slash"></i><?=Translate()->noProject?>
                </span>
            </div>
        </div>
    </div>
</div>
