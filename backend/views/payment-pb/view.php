<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentPb */

$this->title = $model->details;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Privat24'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-pb-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'amt',
            'amt_total',
            'ccy',
            'merchant',
            'order_id',
            'order',
            'details',
            'ext_details',
            'pay_way',
            'state',
            'ref',
            'note',
            'sender_phone',
            //'pay_status',
            [
                'attribute' => 'pay_status',
                'format' => 'html',
                'value' => ($model->pay_status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
            ],
            'date_create',
            'date_update',
        ],
    ]) ?>

</div>
