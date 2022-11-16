<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name_'.Yii::$app->language,
            'slug',
            // 'name_ru',
            // 'name_ua',
            [
                'attribute'=>'parent_id',
                'value' => 'category.name_'.Yii::$app->language,
                'filter'=>ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name_'.Yii::$app->language),
            ],
            'sort_position',
            
            // 'seo_title_en',
            // 'seo_title_ru',
            // 'seo_title_ua',
            // 'seo_description_en',
            // 'seo_description_ru',
            // 'seo_description_ua',
            // 'seo_keywords_en',
            // 'seo_keywords_ru',
            // 'seo_keywords_ua',
            // 'date_create',
            // 'date_update',
            [
                'attribute'=>'status',
                'filter'=> [1 => Yii::t('app', 'Active'), 0 => Yii::t('app', 'Inactive')],
                'format' => 'html',
                'value' => function ($model) {
                    return $status = ($model->status == 1) ? '<i style="color:green;" class="fa fa-check"></i>' : '<i style="color:red;" class="fa fa-minus"></i>' ;
                }
            ],

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
