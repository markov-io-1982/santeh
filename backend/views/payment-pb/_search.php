<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentPbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-pb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'amt') ?>

    <?= $form->field($model, 'amt_total') ?>

    <?= $form->field($model, 'ccy') ?>

    <?= $form->field($model, 'merchant') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'ext_details') ?>

    <?php // echo $form->field($model, 'pay_way') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'ref') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'sender_phone') ?>

    <?php // echo $form->field($model, 'pay_status') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
