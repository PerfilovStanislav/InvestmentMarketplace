<?php
namespace Views\Investment; {
/**
 * @var DetailsMeta $this
 * @property Project $project
 * @property Language $language
 * @property ProjectLang $projectLang
 */
Class DetailsMeta {} }

use Libraries\Screens;
use Models\Table\Language;
use Models\Table\Project;
use Models\Table\ProjectLang; ?>
<?php $description = mb_substr(str_replace(['<\br>', '<', '>', '/', '\\'], '', $this->projectLang->description), 0, 95)?>
<title>RichInme - <?=$this->project->name?></title>
<meta name="keywords" content="<?=Translate()->headKeywords?>"/>
<meta name="description" content="<?=$description?>">

<meta property="fb:app_id" content="2500830970232926">
<meta property="og:image" content="<?=SITE?>/<?=Screens::getOriginalJpgScreen($this->project->id)?>">
<meta property="og:type" content="website" />
<meta property="og:locale" content="<?=$this->language->shortname?>" />
<meta property="og:site_name" content="Richinme" />
<meta property="og:image:width" content="1280">
<meta property="og:image:height" content="960">
<meta property="og:url" content="<?=SITE?>">
<meta property="og:image:type" content="image/png" />
<meta property="og:image:secure_url" content="<?=SITE?>/<?=Screens::getOriginalJpgScreen($this->project->id)?>">
<meta property="og:description" content="<?=$description?>" data-meta-dynamic="true">
<meta property="og:title" content="<?=$this->project->name?>" data-meta-dynamic="true">
<meta property="pageType" content="video">

<meta itemprop="name" content="<?=$description?>">
<meta itemprop="image" content="<?=SITE?>/<?=Screens::getOriginalJpgScreen($this->project->id)?>">
<meta itemprop="description" content="<?=$description?>">

<meta name="twitter:title" content="<?=$this->project->name?>" data-meta-dynamic="true">
<meta name="twitter:site" content="@RichinmeCom" data-meta-dynamic="true">
<meta name="twitter:creator" content="@RichinmeCom" data-meta-dynamic="true">
<meta name="twitter:image:alt" content="<?=$this->project->name?>" data-meta-dynamic="true">
<meta name="twitter:description" content="<?=$description?>" data-meta-dynamic="true">
<meta name="twitter:image" content="<?=SITE?>/<?=Screens::getOriginalJpgScreen($this->project->id)?>">
<meta name="twitter:card" content="summary_large_image">
