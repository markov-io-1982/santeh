<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use backend\models\ProductCombination;

/* @var $this yii\web\View */
/* @var $model backend\models\Cart */

$name = 'name_'. Yii::$app->language;
$product_combination = ProductCombination::getOneProductCombination ($model->product_comb_id);

$this->title = Yii::t('app', 'Cart') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Carts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('<i class="fa fa-edit"></i> '.Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            //'product_id',
            [
                'attribute' => 'product_id',
                'value' => $model->product->$name
            ],
            [
                'attribute' => 'product_comb_id',
                'value' => ($product_combination == null) ? null : $product_combination['a_name'] . ' - ' . $product_combination['v_name']
            ],
            'user_id',
            'amount',
            'price',
            'date',
            //'order_id',
            [
                'attribute' => 'order_id',
                'format' => 'html',
                'value' => (empty($model->order)) ? '<span style="color:red;">' . Yii::t('app', 'Not in order') . '</span>' : Html::a($model->order->code, ['/order/view', 'id' => $model->order_id])               
            ]
        ],
    ]) ?>

</div>
