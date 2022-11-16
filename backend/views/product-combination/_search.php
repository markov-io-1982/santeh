<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCombinationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-combination-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'reserve') ?>

    <?= $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'sort_position') ?>

    <?php // echo $form->field($model, 'attribute_id') ?>

    <?php // echo $form->field($model, 'attribute_value_id') ?>

    <?php // echo $form->field($model, 'buy') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
