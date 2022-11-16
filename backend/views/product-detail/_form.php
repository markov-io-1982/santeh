<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-detail-form">

    <?php $form = ActiveForm::begin(); ?>

<!-- поля перемещены в product -->

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'description_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description_ru')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description_ua')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'complectation_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'complectation_ru')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'complectation_ua')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'seo_title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_title_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_title_ua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_description_ua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords_ua')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buy')->textInput() ?>

    <?= $form->field($model, 'count_views')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
