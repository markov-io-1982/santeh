<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\widgets\CartWidget;
use frontend\widgets\CategoryWidget;
use common\models\Price;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use frontend\widgets\MenuWidget;

$name = 'name_'.Yii::$app->language;
$description = 'description_'.Yii::$app->language;
$seo_title = 'seo_title_'.Yii::$app->language;
$seo_description = 'seo_description_'.Yii::$app->language;
$seo_keywords = 'seo_keywords_'.Yii::$app->language;

$this->title = ($cur_category->$seo_title == '') ? $cur_category->$name : $cur_category->$seo_title;

$this->registerMetaTag([
	'name' => 'description',
	'content' => $cur_category->$seo_description
]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $cur_category->$seo_keywords
]);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('app', 'Catalog'),
    //'url' => ['products']
];

?>

<div class="container">
	<div class="row">
		<div class="col-md-3">
<!--			--><?//= CategoryWidget::widget() ?>
            <!-- Widget Menu -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bars"></i> <a href="/products">Каталог</a> <?php // echo Yii::t('app', 'Categories') ?>
                </div>

                <ul class="catalog category-products">
                    <?= MenuWidget::widget(['tpl' => 'menu']) ?>
                </ul>
            </div>
            <!--/ Widget Menu -->


			<?php
				/*Pjax::begin();
					echo CartWidget::widget()
				Pjax::end();
				*/ 
			?>

		</div>


		<div class="col-md-9">

			<div class="box">
				<h1><?= $cur_category->$name ?></h1>
				<div style="color:#777;"> <?= $cur_category->$description ?> </div>
			</div>


			<div class="products-catalog">

				<div class="row categories-main">
				

				<?php foreach($child_category as $cat): ?>

				<?php 
					$name = 'name_'.Yii::$app->language;
					$description = 'description_'.Yii::$app->language;

				?>

		          <div class="col-sm-4">
		          
		          	<a href="<?= Yii::$app->request->baseUrl; ?>/products/<?= $cat->slug ?>" title="<?= strip_tags($cat->$description) ?>">
		            	<h3><?= $cat->$name ?></h3>
		              <div class="box-category box text-center category-main" style="background-image: url('<?= Yii::$app->request->baseUrl.'/'.$cat->img?>');">
		              </div>
		            </a>
		            
		            <!--
		            <a style="display:block;" href="<?= Yii::$app->request->baseUrl; ?>/products/<?= $cat->slug ?>">
		              <div class="box text-center category-main" <?php if ($cat->img) : ?> style="background-image: url(<?= \Yii::getAlias('@web');?>/<?= $cat->img ?>);" <?php endif;?>>
		                  <h3><?= $cat->$name ?></h3>
		                  <div><?= $cat->$description ?></div>
		              </div>
		            </a>
		            -->
		          </div>

				<?php endforeach; ?>

								</div>

			</div> <!-- /.products-catalog -->

			<div class="clearfix"></div>


		</div><!-- /.col-md-9 -->
	</div><!-- /.row -->

</div><!-- /.container -->