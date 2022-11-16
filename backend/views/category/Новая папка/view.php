<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$name = 'name_' . Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p>
        <?= Html::a('<i class="fa fa-edit"></i> ' . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">

        <div class="col-md-8">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name_' . Yii::$app->language,
                    [
                        'attribute' => 'parent_id',
                        'value' => $model->getCategoryName($model->parent_id)
                    ],
                    'sort_position',
                    'slug',
                    'img',
                    'seo_title_' . Yii::$app->language,
                    'seo_description_' . Yii::$app->language,
                    'seo_keywords_' . Yii::$app->language,
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
        <i class="fa fa-language"></i> <?= Yii::t('app', 'Description in other languages') ?> <i
                        class="fa fa-caret-down"></i>
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
                            'name_' . $key,
                            'seo_title_' . $key,
                            'seo_description_' . $key,
                            'seo_keywords_' . $key,
                        ],
                    ]) ?>

                <?php endforeach; ?>

            </div>
        </div>
        <div class="col-md-4">
            <a class="fancybox" rel="gallery1" href="<?= Url::to('../../frontend/web/' . $model->img) ?>" title="">
                <?= Html::img('../../frontend/web/' . $model->img, ['class' => 'img-responsive', 'alt' => '', 'style' => 'width:100%;']) ?>
            </a>
        </div>
    </div>


</div>
