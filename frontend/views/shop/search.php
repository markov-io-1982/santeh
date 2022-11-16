<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

use common\models\Price;

use frontend\models\ProductCombination;
use frontend\widgets\MenuWidget;


$name = 'name_'.Yii::$app->language;
$description = 'description_'.Yii::$app->language;
$seo_title = 'seo_title_'.Yii::$app->language;
$seo_description = 'seo_description_'.Yii::$app->language;
$seo_keywords = 'seo_keywords_'.Yii::$app->language;

$this->title = Yii::t('app', 'Search for') . ' ' . $q;

// $this->registerMetaTag([
// 	'name' => 'description',
// 	'content' => Yii::t('app', 'Search description')
// ]);
// $this->registerMetaTag([
// 	'name' => 'keywords',
// 	'content' => Yii::t('app', 'Search keywords')
// ]);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('app', 'Search'),
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
				/*
				Pjax::begin();
					echo CartWidget::widget();
				Pjax::end();
				*/
			?>

		</div>


		<div class="col-md-9">

			<div class="box">
				<h1><?= Yii::t('app', 'Search') ?></h1>
				<div style="color:#777;"><?= Yii::t('app', 'For request') ?> <strong>"<?= $q ?>"</strong> <?= Yii::t('app', 'results found') ?>: <strong><?= $count_product ?></strong></div>
			</div>

			<div class="box">
				<div class="sort-panel">
					<span style="font-weight: bold;"><?= Yii::t('app', 'Sort by') ?>:</span>
					<span>
						<?= Yii::t('app', 'name') ?> :
						<?= Html::a('<i class="fa fa-chevron-down"></i>', ['/search?q='.$q.'&sort=name_asc'], ['class' => 'sort-link']) ?>
						<?= Html::a('<i class="fa fa-chevron-up"></i>', ['/search?q='.$q.'&sort=name_desc'], ['class' => 'sort-link']) ?>
					</span> |
					<span>
						<?= Yii::t('app', 'price') ?> :
						<?= Html::a('<i class="fa fa-chevron-down"></i>', ['/search?q='.$q.'&sort=price_asc'], ['class' => 'sort-link']) ?>
						<?= Html::a('<i class="fa fa-chevron-up"></i>', ['/search?q='.$q.'&sort=price_desc'], ['class' => 'sort-link']) ?>
					</span> |

					<span>
						<?= Yii::t('app', 'ratings') ?> :
						<?= Html::a('<i class="fa fa-chevron-down"></i>', ['/search?q='.$q.'&sort=ratings_asc'], ['class' => 'sort-link']) ?>
						<?= Html::a('<i class="fa fa-chevron-up"></i>', ['/search?q='.$q.'&sort=ratings_desc'], ['class' => 'sort-link']) ?>
					</span>

				</div>
			</div>

			<div class="products-catalog">

				<?php foreach($products as $product): ?>
				<?php
					$name = 'name_' . Yii::$app->language;
					$count_product = $product->quantity - $product->reserve;
                    $count_product_with_comb = $count_product;

                    $product_price = $product->price;

                    $product_combinations = ProductCombination::getProductCombinationArrayToProductID($product->id);

                    $product_comb_price = [];
                    $product_comb_visible = [];
                    if (count($product_combinations) > 0) {
                        foreach ($product_combinations as $product_comb_item) {
                            $product_comb_item_quantity = $product_comb_item['quantity'] - $product_comb_item['reserve'];
                            if($product_comb_item_quantity > 0) {
                                $product_comb_visible[] = $product_comb_item;
                                $product_comb_price[] = $product_comb_item['price'];
                            }
                        }
                        if (count($product_comb_visible) > 0) {
                            $count_product_with_comb = $product_comb_visible[0]['quantity']-$product_comb_visible[0]['reserve'];
                        }
                        if(!empty($product_comb_price)) {
                            sort($product_comb_price);
                            $product_price = $product_comb_price[0];
                        }
                    }
				?>

				<div class="product-catalog-item col-sm-4 col-lg-4 col-md-4">
					<div class="thumbnail" id="product-<?= $product->id ?>">
						<a href="<?= Url::to(['products/' . $category_slugs[$product->category_id] .'/'.$product->slug]) ?>">
					    	<?= Html::img('@web/' . $product->img, ['class' => '', 'title' => '', 'style' => 'width:320px; height:250px;']) ?>
						</a>
					    <div class="caption">
					        <h4 class="title">
					        	<?= Html::a($product->$name, ['products/' . $category_slugs[$product->category_id] .'/'.$product->slug], ['class' => '', 'style' => '']); ?>
					        </h4>
					        <p class="text-center price">
					        	<?php /* if($product->price_old != 0): ?>
					        	<span class="old-price">
					        		<del>
					        			<?= Price::getPrice($product->price_old) ?> <?= Price::getCurrency() ?>
					        		</del>
				        		</span>
				        		<?php endif; */?>
				        		<span class="price-label"><?= count($product_comb_visible) > 0 ? ' от ':'' ?>
				        			<span class="app-price"><?= Price::getPrice($product_price) ?></span> <?= Price::getCurrency() ?>
				        		</span>
					        </p>

					        <!-- <p> -->
					        	<?php // substr($product->intro_text_ru, 0, 300)  ?>

					        <!-- </p> -->
					    </div>
					    <div class="ratings">
					        <p class="pull-right">
					        	<?php
					        		if ( $product->count_reviews == 1 || ($product->count_reviews % 10) == 1 ) {
					        			echo $product->count_reviews .' '. Yii::t('app', 'review');
					        		} else if (
					        			($product->count_reviews >= 2 && $product->count_reviews <= 4) ||
					        			($product->count_reviews % 10) == 2 ||
					        			($product->count_reviews % 10) == 3 ||
					        			($product->count_reviews % 10) == 4) {
					        			echo $product->count_reviews .' '. Yii::t('app', 'reviews2');
					        		} else if (
					        			($product->count_reviews >= 5 && $product->count_reviews <= 20) ||
					        			($product->count_reviews % 10) == 5 ||
					        			($product->count_reviews % 10) == 6 ||
					        			($product->count_reviews % 10) == 7 ||
					        			($product->count_reviews % 10) == 8 ||
					        			($product->count_reviews % 10) == 9
					        			) {
					        			echo $product->count_reviews .' '. Yii::t('app', 'reviews5');
					        		} else {
					        			echo Yii::t('app', 'no reviews');
					        		}

					        	 ?>

				        	</p>
					        <p>
					        	<?php
					        		$stars = $product->count_stars;
					        	 	for ($i = 1; $i <= 5; $i++ ) {
					        	 		if ($stars > 0) {
					        	 			echo '<span class="fa fa-star" style="margin-right: 0px; font-size: 21px; color:gold;"></span>';
					        	 		} else {
					        	 			echo '<span class="fa fa-star-o" style="margin-right: 0px; font-size: 21px; color:gold;"></span>';
					        	 		}
							            $stars--;
						        	}
					        	?>
					        </p>
					    </div>
					    <div class="buy-button">
					    	<?php if ($count_product_with_comb > 0): ?>
						    	<div class="text-center">
						    		<p data-id='<?= $product->id ?>' data-count='1' class="app-add-to-cart btn-app-default" style="padding:10px; text-align:center; font-size: 20px;text-transform: uppercase; margin-bottom: 0px;">
						    			<i class="fa fa-cart-plus"></i> <?= Yii::t('app', 'To cart') ?>
						    		</p>
						    	</div>
						    <?php endif; ?>
						    <?php if ($count_product_with_comb <= 0): ?>
						    	<div class="" style="padding:10px; text-align:center; font-size: 20px;text-transform: uppercase;">
						    		<?= Yii::t('app', 'Нет в наличии') ?>
						    	</div>
						    <?php endif ?>
					    </div>
					</div>
				</div> <!-- /.product-catalog-item -->

				<?php endforeach; ?>

			</div> <!-- /.products-catalog -->

			<div class="clearfix"></div>

            <div class="text-center">
                <?= LinkPager::widget([ 'pagination' => $pages ]); ?>
            </div>

		</div><!-- /.col-md-9 -->
	</div><!-- /.row -->

</div><!-- /.container -->