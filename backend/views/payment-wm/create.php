<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PaymentWm */

$this->title = Yii::t('app', 'Create Payment Wm');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Wms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-wm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
