<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Slideshow */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Slideshows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slideshow-view">

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
            //'name_en',
            'name_'.Yii::$app->language,
            //'name_ua',
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => ($model->img != '') ? Html::img('../../frontend/web/' . $model->img, ['style' => 'width:460px;']) : null
            ],
            //'description_en',
            'description_'.Yii::$app->language,
            //'description_ua',
            //'link_title_ua',
            //'link_title_en',
            'link_title_'.Yii::$app->language,
            'link_url',
            'sort_position',
            //'status',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
            ],
            'date_create',
        ],
    ]) ?>

    <span class="btn btn-info" id='open-more-detail'>
        <i class="fa fa-language"></i> <?= Yii::t('app', 'Description in other languages') ?> <i class="fa fa-caret-down"></i>
    </span>

    <div id="more-detail" style="margin-top:20px; display: none;">

        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

            <?php if ($key == Yii::$app->language) {
                continue;
            } ?>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'name_'.$key,
                    'description_'.$key,
                    'link_title_'.$key,
                ],
            ]) ?>

        <?php endforeach; ?>
        
    </div>   

</div>
