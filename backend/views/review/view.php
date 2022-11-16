<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Product;

/* @var $this yii\web\View */
/* @var $model backend\models\Review */

$name = 'name_'.Yii::$app->language;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'product_id',
            [
                'attribute' => 'product_id',
                'value' => Product::findOne(['id' => $model->product_id])->$name
            ],
            'user_id',
            'user_name',
            'review_text',
            'date_create',
            'stars',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i style="color:red;" class="fa fa-minus"></i>',
            ],
        ],
    ]) ?>

</div>
