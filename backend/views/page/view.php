<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$name = 'name_'.Yii::$app->language;
$this->title = $model->$name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

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
            'name_'.Yii::$app->language,
            'slug',
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => ($model->img != '') ? Html::img('../../frontend/web/' . $model->img, ['style' => 'width:360px;']) : null
            ],
            'page_body_'.Yii::$app->language.':html',
            'seo_title_'.Yii::$app->language,
            'seo_description_'.Yii::$app->language,
            'seo_keywords_'.Yii::$app->language,
            'canonical_url',
            'date_create',
            'date_update',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
            ],
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
                    'page_body_'.$key.':html',
                    'seo_title_'.$key,
                    'seo_description_'.$key,
                    'seo_keywords_'.$key,
                ],
            ]) ?>

        <?php endforeach; ?>
        
    </div>  

</div>
