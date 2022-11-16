<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\HtmlBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="html-block-form">

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

    <div class="row">
        <div class="col-md-11">
        
            <?= $form->field($model, 'content_' . Yii::$app->language)->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'basic'
                ]) ?>
                
            <div class="other-description" style="display:none;">
            
                <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                    <?php if ($key == Yii::$app->language) {
                        continue;
                    } ?>

                    <?= $form->field($model, 'content_' . $key)->widget(CKEditor::className(), [
                            'options' => ['rows' => 3],
                            'preset' => 'basic'
                        ]) ?>

                <?php endforeach; ?>                        
            
            </div>
        
        </div>
        
        <div class="col-md-1">
            <div class="btn-other-description">
                <i class="fa fa-language fa-3x"></i>
                <span>Content</span>
            </div>                      
        </div>
    </div>


    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
