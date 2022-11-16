<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PromoStatus */

$name = 'name_'.Yii::$app->language;
$this->title = $model->$name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Promo Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-status-view">

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
            'name_'.Yii::$app->language,
            //'img',
            'sort_position',
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
