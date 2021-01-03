<?php
namespace App\Views\Errors; { /**
 * @var ErrorDefault $this
 * @property string $description
 * @property string $title
 * @property int    $code
 */
Class ErrorDefault {} }
?>
<div class="tray tray-center">
    <div class="content-header">
        <div class="center-block mt50 mw800">
            <h1 class="error-title"> <?=$this->code?>! </h1>
            <h2 class="error-subtitle"><?=$this->title?></h2>
            <?php if($this->description): ?>
                <h2 class="error-subtitle-danger"><?=$this->description?></h2>
            <?php endif; ?>
        </div>
    </div>
</div>