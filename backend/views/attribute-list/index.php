<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AttributeListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List of attributes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create a list of attributes'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            
            [
                'attribute'=> 'name_'.Yii::$app->language,
                'label'=>Yii::t('app', 'Name'),
            ],
            [
                'attribute'=>'category_id',
                'value' => 'category.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],
            [
                'attribute'=>'as_filter',
                'filter'=> [1 => Yii::t('app', 'Yes'), 0 => Yii::t('app', 'No')],
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->as_filter == 1) {
                        return '<i style="color:green;" class="fa fa-check"></i>';
                    } 
                    else {
                        return '<i class="fa fa-minus"></i>';
                    }
                },
            ],
            //'as_filter',
            'sort_position',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add} {view} {update} {delete}',
                'buttons' => [
                    'add' => function ($url, $model) {
                        return Html::a(
                        '<i class="fa fa-plus"></i>', '/admin/attribute-value/create?attr='.$model->id, ['class' => 'btn btn-success', 'title' => Yii::t('app', 'View')]);
                    },    
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
