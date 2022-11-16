<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DeliveryMethod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-method-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        
        <div class="col-md-6">
            
            <?= $form->field($model, 'name_' . Yii::$app->language, [
                'template' => '
                    {label}
                    <div class="input-group">
                        {input}'.
                        '<span class="btn-other-name-delivery-method input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
                    </div>
                    {error}
                ',
            ]); ?>
    
            <div class="row other-name-delivery-method" style="display:none;">
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
                        '<span class="btn-other-description-delivery-method input-group-addon" title="Other description"><i class="fa fa-language"></i></span>
                    </div>
                    {error}
                ',
            ]); ?>
    
            <div class="row other-description-delivery-method" style="display:none;">
                <div class="col-md-12">
                    <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                        <?php if ($key == Yii::$app->language) {
                            continue;
                        } ?>

                            <?= $form->field($model, 'description_' . $key)->textInput(['maxlength' => true]) ?>

                    <?php endforeach; ?>                                  
                </div>
            </div>

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


        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
