<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Code */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="code-form">

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

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Create') : '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
