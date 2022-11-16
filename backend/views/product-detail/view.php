<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'product_id',
            'description_en:ntext',
            'description_ru:ntext',
            'description_ua:ntext',
            'complectation_en:ntext',
            'complectation_ru:ntext',
            'complectation_ua:ntext',
            'seo_title_en',
            'seo_title_ru',
            'seo_title_ua',
            'seo_description_en',
            'seo_description_ru',
            'seo_description_ua',
            'seo_keywords_en',
            'seo_keywords_ru',
            'seo_keywords_ua',
            'buy',
            'count_views',
        ],
    ]) ?>

</div>
