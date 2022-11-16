<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Product;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Carts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create Cart'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute'=>'product_id',
                'value' => 'product.name_'.Yii::$app->language,
                'filter' => ArrayHelper::map(Product::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],
            //'product_id',
            //'product_comb_id',
            //'user_id',
            'amount',
            'price',
            'date',
            [
                'label' => Yii::t('app', 'Status'),
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->order_id == 0) {
                        return '<span style="color:red;">' . Yii::t('app', 'Not in order') . '</span>';
                    } else {
                        return '<span style="color:green;">' . Yii::t('app', 'In order') . '</span>';
                    } 
                },
            ],            
            // [
            //     'attribute'=> 'order_id',
            //     //'value' => 'order.code',
            //     'format' => 'html',
            //     'value' => function ($model) {
            //         return Html::a($model->order->code, ['/order/view', 'id' => $model->order_id]);
            //     },
            //     'filter' => ''
            // ],
            //'order_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                        '<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-default', 'title' => Yii::t('app', 'View')]);
                    },
                    // 'update' => function ($url,$model) {
                    //     return Html::a(
                    //     '<i class="fa fa-edit"></i>', $url, ['class' => 'btn btn-info', 'title' => Yii::t('app', 'Edit')]);
                    // },
                    'delete' => function ($url,$model,$key) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['class' => 'btn btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post'], 'title' => Yii::t('app', 'Delete')]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
