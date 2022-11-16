<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentPb */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-pb-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amt_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ccy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'merchant')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ext_details')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_way')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sender_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'date_update')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
