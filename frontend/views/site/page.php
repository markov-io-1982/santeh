<?php

use yii\helpers\Html;
use yii\helpers\Url;

$name = 'name_'.Yii::$app->language;
$body = 'page_body_'.Yii::$app->language;
$seo_title = 'seo_title_'.Yii::$app->language;
$seo_description = 'seo_description_'.Yii::$app->language;
$seo_keywords = 'seo_keywords_'.Yii::$app->language;

$this->title = $model->$name;
$this->params['breadcrumbs'][] = $this->title;

$this->title = ($model->$seo_title == '') ? $model->$name : $model->$seo_title;

$this->registerMetaTag([
	'name' => 'description',
	'content' => $model->$seo_description,
]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $model->$seo_keywords
]);

$this->registerLinkTag([
	'rel' => 'canonical',
	'href' => ($model->canonical_url == '') ? Url::canonical().'/'.$model->slug : $model->canonical_url
]);


?>

<div class="container">
	
	<div class="page box">
		
		<h1><?= Html::encode($model->$name) ?></h1>
		<hr>

		<div>
			
			<?php if($model->img != ''): ?>
				<?= Html::img('@web/'.$model->img, ['class' => 'img-rounded pull-left', 'style' => 'width:480px; margin: 0 20px 20px 0;']) ?>
			<?php endif; ?>

			<?= $model->$body ?>
		</div>


	</div>

</div>