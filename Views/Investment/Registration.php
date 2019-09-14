<?php
namespace Views\Investment; {

/**
 * @var Registration $this
 * @property Payment[] $payments
 * @property Language[] $mainProjectLanguages
 * @property Language[] $secondaryProjectLanguages
 * @property AuthModel $authModel
 * @property array currency
 * @property LocaleInterface $locale
 */
Class Registration {} }

use Interfaces\LocaleInterface;
use Models\AuthModel;
use Models\Table\Language;
use Models\Table\Payment;
?>
<div class="tray tray-center">
    <div class="content-header">
        <h2> <?=$this->locale['free_4_add_project']?> <b class="text-primary"><?=$this->locale['free']?></b></h2>
        <?php /*if (!($this->authModel->is_authorized)):*/?><!--
            <p class="lead text-danger"><?/*=$this->locale['auth_4_add_project']*/?></p>
        --><?php /*endif;*/?>
    </div>
    <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">
        <div class="panel heading-border panel-<?=$this->authModel->is_authorized ? 'primary' : 'danger'?>">
            <div class="panel-heading">
                <span class="panel-title">
                    <i class="fa fa-pencil-square"></i><?=$this->locale['add_project']?>
                </span>
            </div>
            <form method="post" action="/" id="addproject_form">
                <div class="panel-body bg-light">
                    <div class="section row">
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="name" class="gui-input onlyEn" autocomplete="off"
                                       placeholder="<?=$this->locale['project_name']?>">
                                <label class="field-icon">
                                    <i class="fa fa-pencil"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <div class="smart-widget sm-right smr-100">
                                <label class="field prepend-icon">
                                    <input name="website" class="gui-input onlyUrl" autocomplete="off"
                                           placeholder="<?=$this->locale['project_url']?>">
                                    <label class="field-icon">
                                        <i class="fa fa-globe"></i>
                                    </label>
                                    <label class="button btn-primary check"><?=$this->locale['check']?></label>
                                </label>
                            </div>
                        </div>
                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="text" name="start_date" class="datepicker gui-input onlyDate" autocomplete="off"
                                       placeholder="<?=$this->locale['start_date']?>">
                                <label class="field-icon">
                                    <i class="fa fa-calendar"></i>
                                </label>
                            </label>
                        </div>
                        <div class="section">
                            <label class="field select">
                                <select name="paymenttype">
                                    <option value=""><?=$this->locale['payment_type'][0]?></option>
                                    <option value="1"><?=$this->locale['payment_type'][1]?></option>
                                    <option value="2"><?=$this->locale['payment_type'][2]?></option>
                                    <option value="3"><?=$this->locale['payment_type'][3]?></option>
                                </select>
                                <i class="arrow double"></i>
                            </label>
                        </div>
                        <div class="section-divider mt40 mb25">
                            <span> <?=$this->locale['plans']?> </span>
                        </div>
                        <div class="section mb10" role="group">
                            <div class="section row mb10" role="row">
                                <div class="col-md-3">
                                    <div class="section row mbn">
                                        <div class="col-md-3 w50 mr20">
                                            <button class="button btn-warning remove glyphicons glyphicons-remove_2" type="button" title="<?=$this->locale['remove']?>"> </button>
                                        </div>

                                        <div class="col-md-8 pln prn">
                                            <label class="field append-icon">
                                                <input placeholder="<?=$this->locale['profit']?>" class="gui-input onlyNumber" name="plan_percents[]" autocomplete="off">
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
                                        <label class="button w15"><?=$this->locale['after']?></label>
                                    </div>
                                </div>
                                <div class="col-md-2 mln1 pln">
                                    <label class="field select">
                                        <select name="plan_period_type[]">
                                            <option value="1">          <?=$this->locale['period_name'][1]?></option>
                                            <option value="2">          <?=$this->locale['period_name'][2]?></option>
                                            <option value="3" selected> <?=$this->locale['period_name'][3]?></option>
                                            <option value="4">          <?=$this->locale['period_name'][4]?></option>
                                            <option value="5">          <?=$this->locale['period_name'][5]?></option>
                                            <option value="6">          <?=$this->locale['period_name'][6]?></option>
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
                                        <label class="button prn pln"><?=$this->locale['from']?></label>
                                    </div>
                                </div>
                                <div class="col-md-1 mln1 pln fa" style="top: 0px">
                                    <label class="field select">
                                        <select name="plan_currency_type[]">
                                            <? foreach ($this->currency as $k => $c) {
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
                                    class="button btn-primary copy"> <?=$this->locale['add_plan']?> </button>
                        </div>
                        <div class="section-divider mt40 mb25">
                            <span> <?=$this->locale['ref_program']?> </span>
                        </div>
                        <div class="section mb10 mrn20" role="group">
                            <div class="section row mb10 mrn" role="row">
                                <div class="col-md-1 w50 mr20">
                                    <button type="button"
                                            class="button btn-warning remove glyphicons glyphicons-remove_2"
                                            title="<?=$this->locale['remove']?>"> </button>
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
                                            <n>1</n> <?=$this->locale['level']?></label>
                                    </div>
                                </div>
                                <!-- end section -->
                            </div>
                        </div>

                        <div class="section">
                            <button type="button"
                                    class="button btn-primary copy"> <?=$this->locale['add_level']?> </button>
                        </div>
                        <!-- end section -->


                        <div class="section-divider mt40 mb25">
                            <span> <?=$this->locale['payment_system']?> </span>
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
                            <span> <?=$this->locale['languages']?> </span>
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
                                        class="button btn-primary showPrev"> <?=$this->locale['show_all_langs']?> </button>
                            </div>
                        </div>
                        <div class="section description" hidden>
                            <label class="field prepend-icon">
                                <textarea class="gui-textarea" name="description"
                                          placeholder="<?=$this->locale['description']?> "></textarea>
                                <label class="field-icon">
                                </label>
                            </label>
                        </div>
                        <div class="section-divider mt40 mb25">
                            <span> <?=$this->locale['screenshot']?> </span>
                        </div>
                        <div class="section">
                            <div class="section row br-a br-greyer mn mb15 p2">
                                <div class="col-md-6 img-container pl1 mb1">
                                    <img id="full_site_image" src="/assets/img/screenshot.png"
                                         alt="<?=$this->locale['screenshot']?>">
                                    <input type="hidden" name="screen_data">
                                </div>
                                <div class="col-md-6 img-container pr1 mb1">
                                    <img id="thumb_site_image" src="/assets/img/screenshot.png"
                                         alt="<?=$this->locale['screenshot']?>">
                                    <input type="hidden" name="thumb_data">
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-12 docs-buttons">
                                    <div class="btn-group btn-group-crop">
                                        <button title="Просмотр" data-toggle="tooltip" type="button"
                                                class="btn btn-primary disabled" data-method="getCroppedCanvas"
                                                data-control=1>
                                            <span class="fa fa-picture-o fa-lg "></span>
                                        </button>
                                        <label for="inputImage" class="btn btn-primary btn-upload">
                                            <input type="file" accept="image/*" id="inputImage" class="sr-only">
                                            <span data-toggle="tooltip" data-original-title="" title="">
                                                <span class="fa fa-upload"></span> <?=$this->locale['select_file']?>
                                            </span>
                                        </label>
                                        <button title="<?=$this->locale['view']?>" data-toggle="tooltip" type="button"
                                                class="btn btn-primary disabled" data-method="getCroppedCanvas"
                                                data-control=0>
                                            <span class="fa fa-picture-o fa-lg "></span>
                                        </button>

                                    </div>
                                </div>
                                <div style="display: none;" class="modal fade docs-cropped" id="getCroppedCanvasModal"
                                     aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog"
                                     tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">×
                                                </button>
                                                <h4 class="modal-title"
                                                    id="getCroppedCanvasTitle"><?=$this->locale['view']?></h4>
                                            </div>
                                            <div class="modal-body"><img id="full_site_image" src="" alt="Picture">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                        data-dismiss="modal"><?=$this->locale['close']?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit"
                                    class="button btn-primary" <?=($this->authModel->is_authorized) ? '' : 'disabled';?>> <?=$this->locale['send_form']?> </button>
                        </div>
                    </div>
                    <input type="hidden" name="ajax" value="1">
                </div>
            </form>
        </div>
    </div>
</div>