<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Order;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentPbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payment Privat24');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-pb-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Payment Pb'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'amt',
            'amt_total',
            'ccy',
            //'merchant',
            //'order_id',
            [
                'attribute'=>'order_id',
                'value' => 'order0.code',
                'filter'=>ArrayHelper::map(Order::find()->asArray()->all(), 'id', 'code'),
            ],
            //'order',
            // 'details',
            // 'ext_details',
            // 'pay_way',
            'state',
            // 'ref',
            // 'note',
            // 'sender_phone',
            [
                'attribute'=>'pay_status',
                'filter'=> [1 => Yii::t('app', 'Paid'), 0 => Yii::t('app', 'Not paid')],
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->pay_status == 1) {
                        return '<i style="color:green;" class="fa fa-check"></i>';
                    } 
                    else {
                        return '<i class="fa fa-minus"></i>';
                    }
                },
            ],
            // 'date_create',
            'date_update',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                        '<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-default', 'title' => Yii::t('app', 'View')]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                        '<i class="fa fa-edit"></i>', $url, ['class' => 'btn btn-info', 'title' => Yii::t('app', 'Edit')]);
                    },
                    'delete' => function ($url,$model,$key) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['class' => 'btn btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post'], 'title' => Yii::t('app', 'Delete')]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
