<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Codes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Code'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'code',
            'name_'.Yii::$app->language,
            ///'content:ntext',
            
            [
                'attribute'=>'status',
                'filter'=> [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'No active')],
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status == 1) {
                        return '<i style="color:green;" class="fa fa-check"></i>';
                    } 
                    else {
                        return '<i class="fa fa-minus"></i>';
                    }
                },
            ],
            // 'date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                        '<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-default', 'title' => Yii::t('app', 'View')]);
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                        '<i class="fa fa-edit"></i>', $url, ['class' => 'btn btn-info', 'title' => Yii::t('app', 'Edit')]);
                    },
                    'delete' => function ($url,$model,$key) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['class' => 'btn btn-danger', 'data' => ['confirm' => Yii::t('app', 'Are you sure you want to delete this item?'), 'method' => 'post'], 'title' => Yii::t('app', 'Delete')]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


<div class="well">

    <p> Встроить код на страницу сайта: <code> \frontend\models\code::getContent('код')</code></p>

 </div>