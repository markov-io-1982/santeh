<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create Page'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name_'.Yii::$app->language,
            // 'name_ru',
            // 'name_ua',
            'slug',
            [
                'attribute'=>'status',
                'filter'=> [1 => Yii::t('app', 'Published'), 0 => Yii::t('app', 'Not Published')],
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
            [
                'format' => 'raw',
                'value' => function($data){
                    if ($data->img == '') {
                        return null;
                    } else {
                        return Html::img('../../frontend/web/' . $data->img, [
                            'style' => 'width:200px;'
                        ]);                        
                    }

                },
            ],
            //'page_body_'.Yii::$app->language.':ntext',
            // 'page_body_ru:ntext',
            // 'page_body_ua:ntext',
            // 'seo_title_en',
            // 'seo_title_ru',
            // 'seo_title_ua',
            // 'seo_description_en',
            // 'seo_description_ru',
            // 'seo_description_ua',
            // 'seo_keywords_en',
            // 'seo_keywords_ru',
            // 'seo_keywords_ua',
            // 'canonical_url:url',
            // 'date_create',
            // 'date_update',

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
