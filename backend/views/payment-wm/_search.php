<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentWmSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-wm-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'amt') ?>

    <?= $form->field($model, 'details') ?>

    <?= $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'payee_purse') ?>

    <?php // echo $form->field($model, 'payment_no') ?>

    <?php // echo $form->field($model, 'payment_amount') ?>

    <?php // echo $form->field($model, 'mode') ?>

    <?php // echo $form->field($model, 'sys_invs_no') ?>

    <?php // echo $form->field($model, 'sys_trans_no') ?>

    <?php // echo $form->field($model, 'sys_trans_date') ?>

    <?php // echo $form->field($model, 'payer_purse') ?>

    <?php // echo $form->field($model, 'payer_wm') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
