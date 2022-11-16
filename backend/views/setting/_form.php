<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'name_' . Yii::$app->language, [
        'template' => '
            {label}
            <div class="input-group">
                {input}'.
                '<span class="btn-other-name input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
            </div>
            {error}
        ',
    ]); ?>

    <div class="row other-name" style="display:none;">
        <div class="col-md-12">
            <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                <?php if ($key == Yii::$app->language) {
                    continue;
                } ?>

                    <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>

            <?php endforeach; ?>                                  
        </div>
    </div>

    <?php // $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content_' . Yii::$app->language, [
        'template' => '
            {label}
            <div class="input-group">
                {input}'.
                '<span class="btn-other-description input-group-addon" title="Other description"><i class="fa fa-language"></i></span>
            </div>
            {error}
        ',
    ]); ?>

    <div class="row other-description" style="display:none;">
        <div class="col-md-12">
            <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                <?php if ($key == Yii::$app->language) {
                    continue;
                } ?>

                    <?= $form->field($model, 'content_' . $key)->textInput(['maxlength' => true]) ?>

            <?php endforeach; ?>                                  
        </div>
    </div>

    <?php // $form->field($model, 'date_create')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
