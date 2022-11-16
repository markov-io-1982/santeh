<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Menu;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$name = 'name_'.Yii::$app->language;

$name = 'name_'.Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-view">

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
            // 'name_ru',
            // 'name_ua',
            'url',
            //'parent_id',
            [
                'attribute' => 'parent_id',
                'value' => ($model->parent_id != 0) ? Menu::findOne($model->parent_id)->$name : null,
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>',
            ],
            'sort_position',
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
                ],
            ]) ?>

        <?php endforeach; ?>
        
    </div>

</div>
