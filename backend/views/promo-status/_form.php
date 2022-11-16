<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\PromoStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-status-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name_' . Yii::$app->language, [
                'template' => '
                    {label}
                    <div class="input-group">
                        {input}'.
                        '<span class="btn-other-name-promo-status input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
                    </div>
                    {error}
                ',
            ]); ?>
    
            <div class="row other-name-promo-status" style="display:none;">
                <div class="col-md-12">
                    <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                        <?php if ($key == Yii::$app->language) {
                            continue;
                        } ?>

                            <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>

                    <?php endforeach; ?>                                  
                </div>
            </div> 

            <?= $form->field($model, 'sort_position', [
                'template' => '
                    {label}
                    <div class="input-group">
                        <span class="input-group-addon counter-plus"><i class="fa fa-plus"></i></span>
                        {input}'.
                        '<span class="input-group-addon counter-minus"><i class="fa fa-minus"></i></span>
                    </div>
                    {error}
                ',
            ]); ?>
       
        </div>
        <div class="col-md-6">
            <?php
            // echo $form->field($model, 'fileimg')->widget(FileInput::classname(), [
            //         'pluginOptions' => [
            //             'showRemove' => false,
            //             'showUpload' => false,
            //             'browseClass' => 'btn btn-primary btn-block',
            //             //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            //             'browseLabel' =>  Yii::t('app', 'Select image') .'...'
            //         ],
            //         'options' => ['accept' => 'image/*']
            //     ])

            ?>

            <?php 
                // if (!$model->isNewRecord) {
                //     echo Html::img('../../frontend/web/' . $model->img);
                // }
            ?>            
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
