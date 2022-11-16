<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AttributeList;

/* @var $this yii\web\View */
/* @var $model backend\models\AttributeValue */

$name = 'name_'.Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-value-view">

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
            'name_en',
            'name_ru',
            'name_ua',
            [
                'attribute' => 'attribute_id',
                'value' => AttributeList::getAttributeListName($model->attribute_id)
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => ($model->img != '') ? Html::img('../../frontend/web/' . $model->img, ['style' => 'width:160px;']) : null
            ],
            'sort_position',
            'slug',
        ],
    ]) ?>

</div>
