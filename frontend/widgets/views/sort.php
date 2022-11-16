<?php
//use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>

<div class="box">
	<div class="sort-panel">
		<span style="font-weight: bold;"><?= Yii::t('app', 'Sort by') ?>:</span>
		<span>
			<?= Yii::t('app', 'name') ?> :
			<?= Html::a(
				'<i class="fa fa-chevron-down"></i>', 
				Url::current(['sort' => 'name_asc']), 
				['class' => 'sort-link', 'title' => Yii::t('app', 'Sort by') . ' ' . Yii::t('app', 'name') . Yii::t('app', 'ascending') ]
			) ?> 
			<?= Html::a(
				'<i class="fa fa-chevron-up"></i>', 
				Url::current(['sort' => 'name_desc']), 
				['class' => 'sort-link', 'title' => Yii::t('app', 'Sort by') . ' ' . Yii::t('app', 'name') . ' ' . Yii::t('app', 'descending')]
			) ?>
		</span> | 
		<span>
			<?= Yii::t('app', 'price') ?> :
			<?= Html::a(
				'<i class="fa fa-chevron-down"></i>', 
				Url::current(['sort' => 'price_asc']), 
				['class' => 'sort-link', 'title' => Yii::t('app', 'Sort by') . ' ' . Yii::t('app', 'price') . ' ' . Yii::t('app', 'ascending')]) 
			?> 
			<?= Html::a(
				'<i class="fa fa-chevron-up"></i>', 
				Url::current(['sort' => 'price_desc']), 
				['class' => 'sort-link', 'title' => Yii::t('app', 'Sort by') . ' ' . Yii::t('app', 'price') . ' ' . Yii::t('app', 'descending')]
			) ?>
		</span> | 

		<span>
			<?= Yii::t('app', 'ratings') ?> :
			<?= Html::a(
				'<i class="fa fa-chevron-down"></i>', 
				Url::current(['sort' => 'ratings_asc']), 
				['class' => 'sort-link', 'title' => Yii::t('app', 'Sort by') . ' ' . Yii::t('app', 'ratings') . ' ' . Yii::t('app', 'ascending')]
			) ?> 
			<?= Html::a(
				'<i class="fa fa-chevron-up"></i>', 
				Url::current(['sort' => 'ratings_desc']), 
				['class' => 'sort-link', 'title' => Yii::t('app', 'Sort by') . ' ' . Yii::t('app', 'ratings') . ' ' . Yii::t('app', 'descending')]
			) ?>
		</span>

	</div>
</div>