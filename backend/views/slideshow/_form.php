<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Slideshow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slideshow-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        
        <div class="col-md-6">

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

            <?= $form->field($model, 'description_' . Yii::$app->language, [
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

                            <?= $form->field($model, 'description_' . $key)->textInput(['maxlength' => true]) ?>

                    <?php endforeach; ?>                                  
                </div>
            </div>


            <?= $form->field($model, 'link_title_' . Yii::$app->language, [
                'template' => '
                    {label}
                    <div class="input-group">
                        {input}'.
                        '<span class="btn-other-title input-group-addon" title="Other title"><i class="fa fa-language"></i></span>
                    </div>
                    {error}
                ',
            ]); ?>
    
            <div class="row other-title" style="display:none;">
                <div class="col-md-12">
                    <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                        <?php if ($key == Yii::$app->language) {
                            continue;
                        } ?>

                            <?= $form->field($model, 'link_title_' . $key)->textInput(['maxlength' => true]) ?>

                    <?php endforeach; ?>                                  
                </div>
            </div>

             <?= $form->field($model, 'link_url')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-md-4">
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
            </div>

            <?= $form->field($model, 'status')->checkbox() ?>
            
        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'fileimg')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  Yii::t('app', 'Select image') .'...'
                    ],
                    'options' => ['accept' => 'image/*']
                ])

            ?>

            <?php 
                if (!$model->isNewRecord) {
                    echo Html::img('/' . $model->img, ['style' => 'width: 100%;']);
                }
            ?> 
            
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
