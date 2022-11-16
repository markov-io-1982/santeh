<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_en') ?>

    <?= $form->field($model, 'name_ru') ?>

    <?= $form->field($model, 'name_ua') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'sort_position') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'seo_title_en') ?>

    <?php // echo $form->field($model, 'seo_title_ru') ?>

    <?php // echo $form->field($model, 'seo_title_ua') ?>

    <?php // echo $form->field($model, 'seo_description_en') ?>

    <?php // echo $form->field($model, 'seo_description_ru') ?>

    <?php // echo $form->field($model, 'seo_description_ua') ?>

    <?php // echo $form->field($model, 'seo_keywords_en') ?>

    <?php // echo $form->field($model, 'seo_keywords_ru') ?>

    <?php // echo $form->field($model, 'seo_keywords_ua') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
