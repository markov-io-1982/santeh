<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\DeliveryMethod;
use backend\models\PaymentMethod;
use backend\models\OrderStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'code',
            'user_id',
            [
                'attribute'=>'delivery_method_id',
                'value' => 'deliveryMethod.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(DeliveryMethod::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],
            [
                'attribute'=>'payment_metod_id',
                'value' => 'paymentMethod.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(PaymentMethod::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],

            // 'user_name',
            // 'user_middlename',
            // 'user_lastname',
            // 'user_email:email',
            // 'user_phone',
            // 'user_adress',
            // 'user_comment',
            'total_sum',
            [
                'attribute'=>'order_status_id',
                'value' => 'orderStatus.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(OrderStatus::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],

            // 'date_create',
            // 'date_payment',
            //'type',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
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
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['class' => 'btn btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post'],  'title' => Yii::t('app', 'Delete')]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
