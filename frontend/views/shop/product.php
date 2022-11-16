<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use frontend\widgets\CartWidget;
use frontend\widgets\CategoryWidget;
use frontend\widgets\MenuWidget;

use common\models\Price;

/* vars */
$name = 'name_'.Yii::$app->language;
$seo_title = 'seo_title_'.Yii::$app->language;
$seo_description = 'seo_description_'.Yii::$app->language;
$seo_keywords = 'seo_keywords_'.Yii::$app->language;

$product_count = $product->quantity - $product->reserve;

$product_comb_visible = [];
if (count($product_combinations) > 0) {
    foreach ($product_combinations as $product_comb_item) {
        $product_comb_item_quantity = $product_comb_item['quantity'] - $product_comb_item['reserve'];
        if($product_comb_item_quantity > 0) {
            $product_comb_visible[] = $product_comb_item;
        }
    }
}
$product_count_with_comb = $product_count;
if (count($product_comb_visible) > 0) {
    $product_count_with_comb = $product_comb_visible[0]['quantity']-$product_comb_visible[0]['reserve'];
}


$stock_status = \backend\models\StockStatus::findOne(['id' => $product->stock_status_id]);
if ( count($stock_status) > 0 ) {
	$stock_status = $stock_status->$name;
} else {
	$stock_status = '';
}

$this->title = ($product_detail->$seo_title == '') ? $product->$name : $product_detail->$seo_title;

$this->registerMetaTag([
	'name' => 'description',
	'content' => $product_detail->$seo_description
]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $product_detail->$seo_keywords
]);

$this->registerLinkTag([
	'rel' => 'canonical',
	'href' => ($product_detail->seo_canonical_url == '') ? Url::canonical().'/'.$product->slug : $product_detail->seo_canonical_url
]);

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('app', 'Catalog'),
    'url' => ['products'],
    'title' => Yii::t('app', 'Catalog'),
];

if($category->parent_id != 0) {
	$parent = \frontend\models\Category::find()->select(['name_'.Yii::$app->language, 'slug'])->where(['id' => $category->parent_id])->one();
	$name = 'name_'.Yii::$app->language;
	$this->params['breadcrumbs'][] = [
		'label' => $parent->$name,
	    'url' => ['/products/'.$parent->slug]
	];
}

$this->params['breadcrumbs'][] = [
	'label' => $category->$name,
    'url' => ['products/'.$category->slug],
    'title' => $category->$name,
];
$this->params['breadcrumbs'][] = $product->$name;


?>

<div class="container">

	<div class="row">

		<div class="col-md-3">
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
<!--			--><?//= CategoryWidget::widget() ?>

			<?= CartWidget::widget() ?>

		</div><!-- /.col-md-3 -->

		<div class="col-md-9">

			<div class="row product-info">

				<div class="col-sm-6">

					<!-- Place somewhere in the <body> of your page -->
					<div id="slider" class="flexslider box" style="margin-bottom: 10px;">
					  <ul class="slides">
					    <li class="fancybox" rel="gallery1" href="<?= Url::to('@web/' . $product->img) ?>">
					      <?= Html::img('@web/' . $product->img, ['class' => 'img-responsive']) ?>
					    </li>

						<?php if(count($images > 0)): ?>

							<?php foreach($images as $img): ?>

							    <li class="fancybox" rel="gallery1" href="<?= Url::to('@web/'.$img->url) ?>">
									<?= Html::img('@web/'.$img->url, []) ?>
							    </li>

							<?php endforeach; ?>

						<?php endif; ?>


					    <!-- items mirrored twice, total of 12 -->
					  </ul>
					</div>

					<?php if (count($images) > 0): ?>

						<div id="carousel" class="flexslider" style="margin-bottom: 30px;">
						  <ul class="slides">
						    <li>
						      <?= Html::img('@web/' . $product->img, ['class' => 'img-responsive']) ?>
						    </li>

							<?php foreach($images as $img): ?>

							    <li>
									<?= Html::img('@web/'.$img->url, []) ?>
							    </li>

							<?php endforeach; ?>

						    <!-- items mirrored twice, total of 12 -->
						  </ul>
						</div>

					<?php endif; ?>


					<script>
						$(window).load(function() {
						  // The slider being synced must be initialized first
						  $('#carousel').flexslider({
						    animation: "slide",
						    controlNav: false,
						    animationLoop: false,
						    slideshow: false,
						    itemWidth: 80,
						    itemMargin: 5,
						    asNavFor: '#slider'
						  });

						  $('#slider').flexslider({
						    animation: "slide",
						    controlNav: false,
						    animationLoop: false,
						    slideshow: false,
						    sync: "#carousel"
						  });
						});
					</script>

				</div><!-- /.col-sm-6-->

				<div class="col-sm-6">

					<div class="box">
						<div class="product-title">
							<h1 class="text-center"><?= $product->$name ?></h1>
						</div>

						<div class="product-attributes">

							<?php foreach (\yii\helpers\ArrayHelper::index($product_attributes, null, 'a_name') as $key => $item): ?>
								<span style="display: table-row;">
									<span style="display: table-cell; padding: 2px 10px;">
										<strong><?= $key ?></strong>:
									</span>
									<span style="display: table-cell; padding: 2px 10px;">

										<?php foreach ($item as $i): ?>
											<?= $i['v_name'] ?>
											<?= ( empty($i['img']) ) ? '' : Html::img('@web/'.$i['img'], ['title' => '', 'class' => 'attr-img']) ?>
										<?php endforeach; ?>

									</span>
								</span>
							<?php endforeach ?>

						</div>

						<?php if ($stock_status != ''): ?>
							<div class="stock-status text-center">
								<div class="alert alert-warning" role="alert"><?= $stock_status ?></div>
							</div>
						<?php endif; ?>

						<?php
							if ( $product->kode != 0 ) {
								echo "<div style='text-align: center;'>Арт." . $product->kode . "</div>";
							}
						?>

						<?php if (count($product_comb_visible) > 0): ?>

                        <div class="product-combination" style="margin: 10px 0;">

							<select class="form-control" name="product-combination" id="app-product-combination">

								<?php foreach ($product_comb_visible as $product_comb_item): ?>
									<?php
										$product_comb_item_quantity = $product_comb_item['quantity'] - $product_comb_item['reserve'];
										if ($product_comb_item['default_check'] == 1) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
									?>
									<option <?= $selected ?> data-name="" data-price="<?= Price::getPrice($product_comb_item['price']) ?>" data-price_old="<?= Price::getPrice($product_comb_item['price_old']) ?>" data-amount="<?= $product_comb_item_quantity ?>" value="<?= $product_comb_item['id'] ?>"  style="background-image: url(<?= $product_comb_item['img'] ?>);">
									<?php // $product_comb_item['img'] ?>
										<?= $product_comb_item['attribute'] ?> - <?= $product_comb_item['attribute_value'] ?>
                                        <?php /* if($product_comb_item['price'] > 0): ?>
                                            - <?= Price::getPrice($product_comb_item['price']) ?><?= Price::getCurrency() ?>
                                        <?php endif;*/ ?>
									</option>
			              		<?php endforeach; ?>
			            	</select>

						</div>

                        <div class="price-wrap text-center" style="margin-bottom: 15px 0;">
							<?php /*if($product_comb_visible[0]['price_old'] != 0): ?>
								<span class="price-old-wrap">
									<del>
										<span class="price-old"><?= Price::getPrice($product_comb_visible[0]['price_old']) ?></span> <span><?= Price::getCurrency() ?></span>
									</del>
								</span>
							<?php endif;*/ ?>
                            <span class="price-old-wrap" <?= $product_comb_visible[0]['price_old'] == 0 ? ' style="display: none;"':''?>>
								<del>
									<span class="price-old"><?= Price::getPrice($product_comb_visible[0]['price_old']) ?></span> <span><?= Price::getCurrency() ?></span>
								</del>
							</span>
							<span class="price-new">
								<span class="price"><?= Price::getPrice($product_comb_visible[0]['price']) ?></span>
								<span class="currency"><?= Price::getCurrency() ?></span>
							</span>
						</div>

						<?php else: ?>

                            <div class="price-wrap text-center" style="margin-bottom: 15px 0;">
    							<?php if($product->price_old != 0): ?>
    								<span class="price-old-wrap">
    									<del>
    										<span class="price-old"><?= Price::getPrice($product->price_old) ?></span> <span><?= Price::getCurrency() ?></span>
    									</del>
    								</span>
    							<?php endif; ?>
    							<span class="price-new">
    								<span class="price"><?= Price::getPrice($product->price) ?></span>
    								<span class="currency"><?= Price::getCurrency() ?></span>
    							</span>
    						</div>

                        <?php endif; ?>



						<div class="clear-fix"></div>

                        <div class="text-center buy-buttons">

							<?php if ($product_count_with_comb > 0): ?>
                                <div class="text-center" style="margin: 15px 0;">
        							<div class="form-group" style="margin: 0 auto; width:50%">
        								<label class="sr-only" for="app-product-count"></label>
        								<div class="input-group">
        									<div class="input-group-addon counter-plus">+</div>
        									<input type="text" class="form-control input-lg" id="app-product-count" value="<?= $product->min_order ?>" data-min="<?= $product->min_order ?>" data-max="<?= $product_count ?>" readonly=""/>
        									<div class="input-group-addon counter-minus">-</div>
        								</div>
        							</div>
        						</div>
								
                                <div title="<?= Yii::t('app', 'Add to cart') ?>" data-id='<?= $product->id ?>' class="app-add-to-cart btn btn-app-default">
						    		<i class="fa fa-cart-plus"></i> <?= Yii::t('app', 'To cart') ?>
						    	</div>
                                
                                <div id="app-buy-one-click" data-id='<?= $product->id ?>' class="btn btn-info" data-value="/order/buy-one-click">
					    		     <?= Yii::t('app', 'Buy to one click') ?>
					    	    </div>

                                <?php Modal::begin([
									'header' => '<h4>' . Yii::t('app', 'Buy to one click') . '</h4>',
									'id' => 'buy-to-one-click',
									'size' => 'modal-md',
								]); ?>

    							<div id='modal-buy-one-click-content'>
    								<form id="form-buy-one-click">

    									<div class="row">
    										<div class="col-md-6">
    											<div class="form-group required">
    												<label class="control-label" for="buy-one-click-email">Email</label>
    												<input required type="text" id="buy-one-click-email" class="form-control" name="one-click-email" maxlength="100">
    											</div>
    										</div>
    										<div class="col-md-6">
    											<div class="form-group required">
    									        	<label class="control-label" for="buy-one-click-phone"><?= Yii::t('app', 'Phone') ?></label>
    									        	<div class="input-group">
    									        		<span class="input-group-addon">+38</span>
    									        		<input required type="text" id="buy-one-click-phone" class="form-control" name="one-click-phone">
    									        	</div>
    											</div>
    										</div>
    										<div id="buy-one-click-message" style="color:red;"></div>
    									</div>
    									<div>
    										<button class="btn btn-app-default" type="submit" id="buy-one-click-submit"><?= Yii::t('app', 'Checkout order') ?></button>
    									</div>
    								</form>
    							</div>

    							<?php Modal::end(); ?>

							<?php endif; ?>

							<?php if($product_count_with_comb <= 0): ?>
                                <div class="" style="padding:10px; text-align:center; font-size: 20px;text-transform: uppercase;">
						    		<?= Yii::t('app', 'Нет в наличии') ?>
						    	</div>
							<?php endif; ?>

						</div>

					</div>



				</div><!-- /.col-sm-6-->

			</div><!-- /.row-->

			<div class="product-detail">

				<div class="row">

					<div class="col-sm-12">

						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#description" aria-controls="description" role="tab" data-toggle="tab"><?= Yii::t('app', 'Description') ?></a>
							</li>
							<li role="presentation">
								<a href="#complectation" aria-controls="complectation" role="tab" data-toggle="tab"><?= Yii::t('app', 'Complectation') ?></a>
							</li>
							<li role="presentation">
								<a href="#related" aria-controls="related" role="tab" data-toggle="tab"><?= Yii::t('app', 'Related products') ?></a>
							</li>
							<li role="presentation">
								<a href="#coments" aria-controls="coments" role="tab" data-toggle="tab"><?= Yii::t('app', 'Reviews') ?></a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="description">
								<?php $description = 'description_'.Yii::$app->language; ?>
								<?= $product_detail->$description ?>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="complectation">
								<?php $complectation = 'complectation_'.Yii::$app->language; ?>
								<?= $product_detail->$complectation ?>
							</div>

							<div role="tabpanel" class="tab-pane fade" id="related">

								<div class="row">

								<?php foreach($related_products as $rel): ?>

									<div class="col-xs-6 col-md-3">
										<a href="/products/<?= $rel['category'] ?>/<?= $rel['slug'] ?>" class="thumbnail">
											<?= Html::img('@web/'.$rel['img'], ['title' => $rel['name']]) ?>
										</a>
									</div>

								<?php endforeach; ?>

								</div>

							</div>

							<div role="tabpanel" class="tab-pane fade" id="coments">

								<h2><?= Yii::t('app', 'Reviews') ?></h2>
								<hr>

								<ul class="media-list">

									<?php foreach(\frontend\models\Review::find()->where(['product_id' => $product->id, 'status' => 1])->all() as $one_review):  ?>

									  <li class="media">
<!-- 									    <div class="media-left">
									      <a href="#">
									        <img class="media-object" src="" alt="">
									      </a>
									    </div> -->
									    <div class="media-body">
									      <h4 class="media-heading"><?= $one_review->user_name ?> <small><?= $one_review->date_create ?></small></h4>
									      <?= $one_review->review_text ?>
									    </div>
									  </li>

									<?php endforeach; ?>

								</ul>

								<div>
									<span id="app-add-review" class="btn btn-default"><?= Yii::t('app', 'Add review') ?></span>
								</div>

								<?php Modal::begin([
									'header' => '<h4>' . Yii::t('app', 'Review') . '</h4>',
									'id' => 'add-review',
									'size' => 'modal-lg',
								]); ?>

								<div id='modal-add-review-content'>
									<form id="form-add-review">

									  <div class="form-group">
									  	<div class="row">
										    <label for="user-name" class="col-sm-2 control-label"><?= Yii::t('app', 'Name') ?></label>
										    <div class="col-sm-10">
										      <input type="text" class="form-control" id="user-name" placeholder="<?= Yii::t('app', 'Name') ?>">
										    </div>
									    </div>
									  </div>

									  <div class="form-group">
									  	<div class="row">
										    <label for="user-comment" class="col-sm-2 control-label"><?= Yii::t('app', 'Comment'); ?></label>
										    <div class="col-sm-10">
										      <textarea id="user-comment" class="form-control" rows="3" placeholder="<?= Yii::t('app', 'Comment'); ?>"></textarea>
										    </div>
									    </div>
									  </div>

									  <div class="form-group">
									  	<div class="row">
										    <label class="col-sm-2 control-label"><?= Yii::t('app', 'Mark') ?></label>
										    <div class="col-sm-10">
										      <div class="stars">
											      <i id="star-1" class="star fa fa-star-o fa-2x"></i>
											      <i id="star-2" class="star fa fa-star-o fa-2x"></i>
											      <i id="star-3" class="star fa fa-star-o fa-2x"></i>
											      <i id="star-4" class="star fa fa-star-o fa-2x"></i>
											      <i id="star-5" class="star fa fa-star-o fa-2x"></i>
										      </div>
										    </div>
									    </div>
									  </div>
										<div class="form-group">
											<button class="btn btn-app-default" type="submit" id="add-review-submit"><?= Yii::t('app', 'Leave a review') ?></button>
										</div>


									</form>
								</div>

								<?php Modal::end(); ?>

							</div>
						</div>

					</div><!-- /.col-sm-12-->

				</div><!-- /.row-->

			</div><!-- /.product-detail -->

		</div><!-- /.col-md-9 -->

	</div> <!-- /.row -->

</div>
