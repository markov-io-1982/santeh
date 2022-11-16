<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentWm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-wm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'payee_purse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mode')->textInput() ?>

    <?= $form->field($model, 'sys_invs_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sys_trans_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sys_trans_date')->textInput() ?>

    <?= $form->field($model, 'payer_purse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payer_wm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
