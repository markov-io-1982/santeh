<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\AttributeList;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AttributeValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Attribute Values');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-value-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create Attribute Value'), ['create'], ['class' => 'btn btn-success']) ?>
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
            //'name_ru',
            //'name_ua',
            [
                'attribute'=>'attribute_id',
                'value' => 'attributeList.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(AttributeList::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],
            [
                'format' => 'raw',
                'value' => function($data){
                    if ($data->img == '') {
                        return null;
                    } else {
                        return Html::img('../../frontend/web/' . $data->img, [
                            'style' => 'width:36px;'
                        ]);                        
                    }

                },
            ],
            'sort_position',

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
