<?php
namespace App\Views\Investment;
{
    /**
     * @var Show $this
     * @property Languages $languages
     * @property Payment[] payments
     * @property Project[] $projects
     * @property AbstractLanguage $locale
     * @property bool $isAdmin
     * @property Language $pageLanguage
     * @property array $banners
     * @property array $counts
     */
    class Show
    {
    }
}

use App\Helpers\Data\Currency;
use App\Helpers\Locales\AbstractLanguage;
use App\Libraries\Screens;
use App\Models\Collection\Languages;
use App\Models\Constant\PlanPeriodType;
use App\Models\Constant\ProjectStatus;
use App\Models\Constant\Views;
use App\Models\MView\MVProjectLang;
use App\Models\Table\{Payment, Project, Language, ProjectLang};
?>

<div id="investment-info" class="flex fw_w mb10">
    <div class="f_1_1_60 fw_w">
        <div class="panel-heading">
            <span class="panel-icon">
                <i class="glyphicons glyphicons-pencil"></i>
            </span>
            <span class="panel-title"> <?=Translate()->aboutUs?></span>
        </div>
        <div class="panel-body bg-c_white max-height">
            <p class="fs15px">
                <i><?=Translate()->about[0]?></i> <b><i class="c0af fs1_125em">Rich</i><i class="cf33">inMe</i></b> <?=Translate()->about[1]?>
            </p>
            <p class="fs14px"><?=Translate()->about[2]?></p>
            <p class="fs14px">
                <?=Translate()->about[3]?> <a href="/Purchase/banners" class="ajax page"><?=Translate()->about[4]?></a> <?=Translate()->about[5]?>
            </p>
        </div>
    </div>
    <div class="flex f_1_1_40 fw_w mnw300 fd-c">
        <div class="flex f_1_1_50 fw_w">
            <div class="f_1_1_50 mnw200">
                <div class="panel-heading">
                    <span class="panel-icon">
                        <i class="glyphicons glyphicons-charts"></i>
                    </span>
                    <span class="panel-title"><?=Translate()->forLastMonth?></span>
                </div>
                <div class="panel-body bg-c_white max-height">
                    <p class="fs30px mn">+<?=$this->counts['new_last_month']?></p>
                    <p class="fs20px text-success-darker mn tt-u"><?=Translate()->new?></p>
                </div>
            </div>
            <div class="f_1_1_50 mnw200">
                <div class="panel-heading">
                    <span class="panel-icon">
                        <i class="glyphicons glyphicons-signal"></i>
                    </span>
                    <span class="panel-title"><?=Translate()->forLastMonth?></span>
                </div>
                <div class="panel-body bg-c_white max-height">
                    <p class="fs30px mn">+<?=$this->counts['scam_last_month']?></p>
                    <p class="fs20px text-danger-dark mn tt-u"><?=Translate()->scam?></p>
                </div>
            </div>
        </div>
        <div class="flex f_1_1_50 fw_w">
            <div class="f_1_1_50 mnw200">
                <div class="panel-heading">
                    <span class="panel-icon">
                        <i class="glyphicons glyphicons-charts"></i>
                    </span>
                    <span class="panel-title"><?=Translate()->forAllTime?></span>
                </div>
                <div class="panel-body bg-c_white max-height">
                    <p class="fs30px mn"><?=$this->counts['active']?></p>
                    <p class="fs20px text-success-darker mn tt-u"><?=Translate()->active?></p>
                </div>
            </div>
            <div class="f_1_1_50 mnw200">
                <div class="panel-heading">
                    <span class="panel-icon">
                        <i class="glyphicons glyphicons-signal"></i>
                    </span>
                    <span class="panel-title"><?=Translate()->forAllTime?></span>
                </div>
                <div class="panel-body bg-c_white max-height">
                    <p class="fs30px mn"><?=$this->counts['total']?></p>
                    <p class="fs20px text-primary-dark mn tt-u"><?=Translate()->total?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bnrs bnrs_top mb10">
    <?php
    $count = count($this->banners);
    $count -= $count % 2;
    ?>
    <?php for ($i = 0; $i <= $count; $i++): ?>
        <span>
            <a class="svg bnr_top" href="/purchase/banners" target="_blank" rel="noreferrer">
                <img class="bnr_top" src="/assets/bnrs/empty.jpg" alt="ad">
            </a>
        </span>
    <?php endfor; ?>
    <span>
        <a class="ajax page svg bnr_top" href="/purchase/banners" rel="noreferrer">
            <object data="/assets/bnrs/bnr1.svg?<?= vsprintf('row1=%s&row2=%s', explode('|', sprintf(Translate()->placeBanner, 20))) ?>"
                    type="image/svg+xml" id="bnr1"></object>
        </a>
    </span>
</div>

<div class="filters mb10" id="<?= Views::PROJECT_FILTER ?>">
    <?= $this->{Views::PROJECT_FILTER} ?>
</div>

<div class="investment" itemscope itemtype="http://schema.org/OfferCatalog">
    <?php $isFirstRow = true;
    foreach ($this->projects as $project): ?>
        <div class="panel mb25 mt5" project_id="<?= $project->id ?>" itemprop="itemListElement" itemscope
             itemtype="http://schema.org/Product">
            <meta itemprop="description" content="<?= $project->id ?>">
            <div class="panel-heading" itemprop="productID" content="<?= $project->id ?>">
                <?php if ($this->isAdmin): ?>
                    <span>
                        <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle" aria-label="edit">
                            <span class="fa fa-pencil"></span>
                        </button>
                        <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu">
                            <li>
                                <?php foreach (array_diff(ProjectStatus::getValues(), [$project->status_id]) as $statusId): ?>
                                    <a class="ajax"
                                       href="/Investment/changeStatus/status/<?= ProjectStatus::getConstNameLower($statusId) ?>/project/<?= $project->id ?>">
                                        <?= ProjectStatus::getConstNameLower($statusId) ?>
                                    </a>
                                <?php endforeach; ?>
                            </li>
                        </ul>
                    </span>

                    <span>
                        <button data-toggle="dropdown" class="btn btn-sm dropdown-toggle btn-warning"
                                aria-label="Update screenshot">
                            <span class="fa fa-image"></span>
                        </button>
                        <ul class="dropdown-menu pv5 animated animated-short flipInX" role="menu2">
                            <li>
                                <a class="ajax" href="/Investment/reloadScreen/project/<?= $project->id ?>">
                                    Reload ScreenShot
                                </a>
                            </li>
                        </ul>
                    </span>
                <?php endif; ?>

                <span class="panel-title">
                    <a target="_blank" rel="nofollow noopener" itemprop="url"
                       href="/Investment/redirect/project/<?= $project->id ?>">
                        <span itemprop="name"><?= $project->name ?></span>
                    </a>
                </span>
            </div>
            <div class="panel-body inforow flex fw_w jc_sa f_1_1_auto">
                <div class="mnw270">
                    <div class="thumbnail" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                        <meta itemprop="description" content="<?= $project->name ?>">
                        <span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject">
                            <a class="ajax page" href="/Investment/details/site/<?= $project->url ?>/lang/<?= $this->pageLanguage->shortname ?>">
                                <img src="/<?= $isFirstRow
                                    ? Screens::withTime(Screens::getJpgThumb($project->id))
                                    : Screens::withTime(Screens::getPreThumb($project->id)) ?>"
                                     alt="<?= $project->name ?>"
                                     itemprop="image"
                                     class="media-object"
                                     href="<?= SITE . '/' . Screens::withTime(Screens::getOriginalJpgScreen($project->id)) ?>"
                                     <?= !$isFirstRow ? 'realthumb="/' . Screens::withTime(Screens::getThumb($project->id)) . '"' : '' ?>
                                >
                            </a>
                        </span>
                    </div>
                </div>
                <div class="mnw230" style="flex: 16 0">
                    <div class="panel-heading lh30 h-30">
                        <span class="panel-icon">
                            <i class="fa fa-signal"></i>
                        </span>
                        <span class="panel-title"><?= Translate()->plans ?></span>
                    </div>
                    <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                        <table class="table mbn justify">
                            <thead>
                            <tr>
                                <th><?= Translate()->profit ?></th>
                                <th><?= Translate()->period ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($project->plan_percents as $key => $plan) { ?>
                                <tr>
                                    <td><?= $project->plan_percents[$key] ?>%</td>
                                    <td><?= $project->plan_period[$key] . ' ' . Translate()->getPeriodName($project->plan_period_type[$key], $project->plan_period[$key]) ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mnw270" style="flex: 30 0">
                    <div class="panel-heading lh30 h-30">
                        <span class="panel-icon">
                            <i class="fa fa-gear"></i>
                        </span>
                        <span class="panel-title"><?= Translate()->options ?></span>
                    </div>
                    <div class="panel-body panel-scroller scroller-xs scroller-pn pn scroller-active scroller-success mih-220">
                        <table class="table mbn tc-bold-last table-hover justify">
                            <tbody>
                            <tr>
                                <td><?= Translate()->rating ?></td>
                                <td itemprop="productionDate" class="fw600">
                                    <?= $project->rating ?>
                                    <div class="progress progress-bar-xs">
                                        <div class="progress-bar progress-bar-<?= [
                                            'danger', 'warning-dark', 'warning', 'success-light', 'success'
                                        ][(int)($project->rating / 2)] ?>"
                                             style="width: <?= $project->rating * 10.0 ?>%;"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Translate()->dateStart ?></td>
                                <td itemprop="productionDate">
                                    <span class="fw600"><?= $project->start_date->format('Y-m-d') ?></span>
                                    <span class="nowrap">
                                        (<?= $days = $project->start_date->diff(new \DateTime())->days ?> <?= Translate()->getPeriodName(PlanPeriodType::DAY, $days) ?>)
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Translate()->minDeposit ?></td>
                                <td itemprop="productionDate" class="fw600"><?= $project->min_deposit ?> <span
                                            class="fa"><?= Currency::getCurrency()[$project->currency]['i'] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><?= Translate()->refProgram ?></td>
                                <td class="fw600"><?= implode('%, ', $project->ref_percent) . '%' ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <?= Translate()->paymentSystem ?>
                                </td>
                                <td><?php foreach ($project->id_payments as $paymentId):
                                        /** @var Payment $payment */
                                        $payment = $this->payments->{$paymentId};
                                        ?>
                                        <i class="pay pay-<?= $payment->name ?> mb10"
                                           title="<?= $payment->name ?>"></i>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mnw270 panel-widget chat-widget" style="flex: 60 0">
                        <div class="panel-heading lh30 h-30">
                            <span class="panel-icon">
                                <i class="fa fa-comments"></i>
                            </span>
                            <span class="panel-title"><?= Translate()->chat ?></span>
                        </div>
                        <div class="panel-body bg-light dark panel-scroller scroller-lg pn mh-179">
                        </div>
                        <form class="admin-form chat-footer" chat_id="<?= $project->id ?>"
                                  data-chat="<?= $project->id ?>" autocomplete="off">
                                <label class="field prepend-icon">
                                    <input name="message" class="gui-input"
                                           placeholder="<?= Translate()->writeMessage ?>">
                                    <label class="field-icon">
                                        <i class="fa fa-pencil"></i>
                                    </label>
                                    <div class="icon_send"></div>
                                </label>
                            </form>
                    </div>
            </div>
        </div>
        <?php $isFirstRow = false; endforeach; ?>
</div>

<div class="filters mb10" id="<?= Views::PROJECT_FILTER ?>">
    <?= $this->{Views::PROJECT_FILTER} ?>
</div>
