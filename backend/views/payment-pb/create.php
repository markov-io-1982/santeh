<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PaymentPb */

$this->title = Yii::t('app', 'Create Payment Pb');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Pbs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-pb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
