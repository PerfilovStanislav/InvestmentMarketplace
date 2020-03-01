<?php
namespace Views\Investment; {

/**
 * @var Registration $this
 * @property Payment[] $payments
 * @property Language[] $mainProjectLanguages
 * @property Language[] $secondaryProjectLanguages
 * @property CurrentUser $authModel
 * @property array currency
 * @property AbstractLanguage $locale
 */
Class Registration {} }

use Helpers\Locales\AbstractLanguage;
use Models\CurrentUser;
use Models\Table\Language;
use Models\Table\Payment;
?>
<div class="tray tray-center">
    <div class="content-header">
        <h2> <?=Translate()->freeForAddProject?> <b class="text-primary"><?=Translate()->free?></b></h2>
        <?php /*if (!($this->authModel->is_authorized)):*/?><!--
            <p class="lead text-danger"><?/*=Translate()->auth_4_addProject*/?></p>
        --><?php /*endif;*/?>
    </div>
    <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-<?=$this->authModel->is_authorized ? 'primary' : 'danger'?>">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="fa fa-pencil-square"></i><?=Translate()->addProject?>
                </span>
            </div>
            <form method="post" action="/" id="addproject_form">
                <div class="panel-body bg-light">
                    <div class="section row">
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="name" class="gui-input onlyEn" autocomplete="off"
                                       placeholder="<?=Translate()->projectName?>">
                                <label class="field-icon">
                                    <i class="fa fa-pencil"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <div class="smart-widget sm-right smr-100">
                                <label class="field prepend-icon">
                                    <input name="website" class="gui-input onlyUrl" autocomplete="off"
                                           placeholder="<?=Translate()->projectUrl?>">
                                    <label class="field-icon">
                                        <i class="fa fa-globe"></i>
                                    </label>
                                    <label class="button btn-primary check"><?=Translate()->check?></label>
                                </label>
                            </div>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="text" name="start_date" class="datepicker gui-input onlyDate" autocomplete="off"
                                       placeholder="<?=Translate()->startDate?>">
                                <label class="field-icon">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <label class="field select">
                                <select name="paymenttype">
                                    <option value=""><?=Translate()->paymentType[0]?></option>
                                    <option value="1"><?=Translate()->paymentType[1]?></option>
                                    <option value="2"><?=Translate()->paymentType[2]?></option>
                                    <option value="3"><?=Translate()->paymentType[3]?></option>
                                </select>
                                <i class="arrow double"></i>
                            </label>
                        </div>
                        <div class="section-divider mt40 mb25">
                            <span> <?=Translate()->plans?> </span>
                        </div>
                        <div class="section mb10" role="group">
                            <div class="section row mb10" role="row">
                                <div class="col-md-3">
                                    <div class="section row mbn">
                                        <div class="col-md-3 w50 mr20">
                                            <button class="button btn-warning remove glyphicons glyphicons-remove_2" type="button" title="<?=Translate()->remove?>"> </button>
                                        </div>

                                        <div class="col-md-8 pln prn">
                                            <label class="field append-icon">
                                                <input placeholder="<?=Translate()->profit?>" class="gui-input onlyNumber" name="plan_percents[]" autocomplete="off">
                                                <label class="field-icon">
                                                    <i class="fa fa-percent"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 prn">
                                    <div class="smart-widget sm-left sml-80">
                                        <label class="field append-icon">
                                            <input class="gui-input onlyNumber" name="plan_period[]" autocomplete="off">
                                            <label class="field-icon">
                                                <i class="glyphicons glyphicons-clock"></i>
                                            </label>
                                        </label>
                                        <label class="button w15"><?=Translate()->after?></label>
                                    </div>
                                </div>
                                <div class="col-md-2 mln1 pln">
                                    <label class="field select">
                                        <select name="plan_period_type[]">
                                            <option value="1">          <?=Translate()->periodName[1]?></option>
                                            <option value="2">          <?=Translate()->periodName[2]?></option>
                                            <option value="3" selected> <?=Translate()->periodName[3]?></option>
                                            <option value="4">          <?=Translate()->periodName[4]?></option>
                                            <option value="5">          <?=Translate()->periodName[5]?></option>
                                            <option value="6">          <?=Translate()->periodName[6]?></option>
                                        </select>
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                                <div class="col-md-3 prn">
                                    <div class="smart-widget sm-left sml-50">
                                        <label class="field append-icon">
                                            <input class="gui-input onlyNumber" name="plan_start_deposit[]" autocomplete="off">
                                            <label class="field-icon">
                                                <i class="fa fa-money"></i>
                                            </label>
                                        </label>
                                        <label class="button prn pln"><?=Translate()->from?></label>
                                    </div>
                                </div>
                                <div class="col-md-1 mln1 pln fa" style="top: 0px">
                                    <label class="field select">
                                        <select name="plan_currency_type[]">
                                            <?php foreach ($this->currency as $k => $c) {
                                                if ($k == 0) continue;
                                                printf('<option value="%d" %s title="%s">%s</option>', $k, $k == 1 ? 'selected' : '', $c['t'], $c['i']);
                                            }?>
                                        </select>
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="section">
                            <button type="button"
                                    class="button btn-primary copy"> <?=Translate()->addPlan?> </button>
                        </div>
                        <div class="section-divider mt40 mb25">
                            <span> <?=Translate()->refProgram?> </span>
                        </div>
                        <div class="section mb10 mrn20" role="group">
                            <div class="section row mb10 mrn" role="row">
                                <div class="col-md-1 w50 mr20">
                                    <button type="button"
                                            class="button btn-warning remove glyphicons glyphicons-remove_2"
                                            title="<?=Translate()->remove?>"> </button>
                                </div>

                                <div class="col-md-11 pln">
                                    <div class="smart-widget sm-left sml-120">
                                        <label class="field append-icon">
                                            <input name="ref_percent[]" class="gui-input onlyNumber" placeholder="%" autocomplete="off">
                                            <label class="field-icon">
                                                <i class="fa fa-street-view"></i>
                                            </label>
                                        </label>
                                        <label class="button prn pln">
                                            <n>1</n> <?=Translate()->level?></label>
                                    </div>
                                </div>
                                <!-- end section -->
                            </div>
                        </div>

                        <div class="section">
                            <button type="button"
                                    class="button btn-primary copy"> <?=Translate()->addLevel?> </button>
                        </div>
                        <!-- end section -->


                        <div class="section-divider mt40 mb25">
                            <span> <?=Translate()->paymentSystem?> </span>
                        </div>

                        <div class="payments">
                            <div class="section row">
                                <?php
                                $div = ceil(count($this->payments) / 3);
                                $i = 0;
                                foreach ($this->payments as $v) {
                                    if ($i % $div === 0) echo '<div class="col-md-4 pad-r40 border-right">';
                                    echo '<label class="block mt15 option option-primary">
                                        <input type="checkbox" name="id_payments[]" value="' . $v->id . '">
                                        <span class="checkbox"></span> <i class="pay pay-' . $v->name . ' mbn" ></i> ' . $v->name . '</label>';
                                    if (($i + 1) % $div === 0 || $i === count($this->payments)) echo '</div>';
                                    $i++;
                                }
                               ?>
                            </div>
                        </div>
                        <div class="section-divider mt40 mb25">
                            <span> <?=Translate()->languages?> </span>
                        </div>
                        <div class="langs">
                            <div class="section row">
                                <?php
                                $div = ceil(count($this->mainProjectLanguages) / 3);
                                $i = 0;
                                foreach ($this->mainProjectLanguages as $v) {
                                    if ($i % $div === 0) echo '<div class="col-md-4 pad-r40 border-right">';
                                    echo '<label class="block mt15 option option-primary"><input type="checkbox" name="lang[]" value="' . $v->id . '">',
                                    '<span class="checkbox"></span> <i class="flag flag-' . $v->flag . '" ></i><txt>' . $v->name . " ( {$v->own_name} )" . '</txt></label>';
                                    if (($i + 1) % $div === 0 || $i === count($this->mainProjectLanguages)) echo '</div>';
                                    $i++;
                                }
                               ?>
                            </div>
                            <div class="section row" hidden>
                                <?php
                                $div = ceil(count($this->secondaryProjectLanguages) / 3);
                                $i = 0;
                                foreach ($this->secondaryProjectLanguages as $v) {
                                    if ($i % $div === 0) echo '<div class="col-md-4 pad-r40 border-right">';
                                    echo '<label class="block mt15 option option-primary"><input type="checkbox" name="lang[]" value="' . $v->id . '">',
                                    '<span class="checkbox"></span> <i class="flag flag-' . $v->flag . '" ></i><txt>' . $v->name . " ( {$v->own_name} )" . '</txt></label>';
                                    if (($i + 1) % $div === 0 || $i === count($this->secondaryProjectLanguages) - 1) echo '</div>';
                                    $i++;
                                }
                               ?>
                            </div>
                            <div class="section">
                                <button type="button"
                                        class="button btn-primary showPrev"> <?=Translate()->showAllLangs?> </button>
                            </div>
                        </div>
                        <div class="section description" hidden>
                            <label class="field prepend-icon">
                                <textarea class="gui-textarea" name="description"
                                          placeholder="<?=Translate()->description?> "></textarea>
                                <label class="field-icon">
                                </label>
                            </label>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit"
                                    class="button btn-primary"> <?=Translate()->sendForm?> </button>
                        </div>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </div>
            </form>
        </div>
    </div>
</div>