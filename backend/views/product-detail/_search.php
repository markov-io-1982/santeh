<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'description_en') ?>

    <?= $form->field($model, 'description_ru') ?>

    <?= $form->field($model, 'description_ua') ?>

    <?php // echo $form->field($model, 'complectation_en') ?>

    <?php // echo $form->field($model, 'complectation_ru') ?>

    <?php // echo $form->field($model, 'complectation_ua') ?>

    <?php // echo $form->field($model, 'seo_title_en') ?>

    <?php // echo $form->field($model, 'seo_title_ru') ?>

    <?php // echo $form->field($model, 'seo_title_ua') ?>

    <?php // echo $form->field($model, 'seo_description_en') ?>

    <?php // echo $form->field($model, 'seo_description_ru') ?>

    <?php // echo $form->field($model, 'seo_description_ua') ?>

    <?php // echo $form->field($model, 'seo_keywords_en') ?>

    <?php // echo $form->field($model, 'seo_keywords_ru') ?>

    <?php // echo $form->field($model, 'seo_keywords_ua') ?>

    <?php // echo $form->field($model, 'buy') ?>

    <?php // echo $form->field($model, 'count_views') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
