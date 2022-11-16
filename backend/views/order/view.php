<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\Order;
/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-edit"></i> '.Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> '.Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php $name = 'name_'.Yii::$app->language ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'user_id',
            [
                'attribute' => 'delivery_method_id',
                'value' => $model->deliveryMethod->$name
            ],
            [
                'attribute' => 'payment_metod_id',
                'value' => $model->paymentMethod->$name
            ],
            'user_name',
            'user_middlename',
            'user_lastname',
            'user_email:email',
            'user_phone',
            'user_adress',
            'user_comment',
            'total_sum',
            [
                'attribute' => 'order_status_id',
                'value' => $model->orderStatus->$name
            ],
            'date_create',
            'date_payment',
            [
                'attribute' => 'type',
                'value' => $model->getType($model->type)
            ],
            [
                'label' => 'Products',
                'format' => 'raw',
                'value' => Order::getProductsInOrder($model->id),
            ],
        ],
    ]) ?>


</div>
