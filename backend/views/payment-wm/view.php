<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PaymentWm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Wms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-wm-view">

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
            'user_id',
            'amt',
            'details:html',
            'order_id',
            'payee_purse',
            'payment_no',
            'payment_amount',
            //'mode',

            [
                'attribute'=>'mode',
                'format' => 'html',
                'value' => $model->getMode($model->mode)
            ],

            'sys_invs_no',
            'sys_trans_no',
            'sys_trans_date',
            'payer_purse',
            'payer_wm',
            'date_create',
            'phone',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
            ],
            'note',
        ],
    ]) ?>

</div>
