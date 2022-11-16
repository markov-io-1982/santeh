<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;
use frontend\models\Category;
use common\models\Price;

$this->title = Yii::t('app', 'Shop cart');

?>

<div class="container">
	<div class="row">
		<div class="col-md-9">

			<div class="box">

				<h1><?= $this->title ?></h1>

				<hr>

				<div class="cart-body table-responsive">

	                <?php Pjax::begin([
	                    'id' => 'cart-items'
	                ]); ?>

					<table class="table">
						<thead>
							<tr>
								<th>
									<?= Yii::t('app', 'Product') ?>
								</th>
								<th></th>
								<th><?= Yii::t('app', 'Quantity') ?></th>
								<th></th>
								<th><?= Yii::t('app', 'Unit price') ?></th>
								<th><?= Yii::t('app', 'Total sum') ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>

							<?php $total = 0; ?>
							<?php foreach($model as $item): ?>

								<?php
									$product_name = $product_arr[$item->product_id]['name'];
									$product_slug = $product_arr[$item->product_id]['slug'];
									$product_category = $category[$product_arr[$item->product_id]['category_id']];

									$max = $product_arr[$item->product_id]['quantity'] - $product_arr[$item->product_id]['reserve'];

                                    $price = $item->price;
                                    if($item->product_comb_id>0) {
									   $price = $product_combination_arr[$item->product_comb_id]['price'];
                                       $price = Price::getPrice($price);
                                       $max = $product_combination_arr[$item->product_comb_id]['quantity'] - $product_combination_arr[$item->product_comb_id]['reserve'];
									}


                                    if($item->amount >= $max) $max = $item->amount;

									//$total += Price::getPrice($price) * $item->amount;
                                    $total += $price * $item->amount;


									$combination = '';
									if ($product_arr[$item->product_id]['isset_product_combination'] == 1) {
										$combination = '(' . $attributes_value_arr[$product_combination_arr[$item->product_comb_id]['attribute_value']] . ')';
									}

								?>

								<tr class="item" id="item-<?= $item->id ?>">
									<td>
										<a href="<?= '/products/' . $product_category . '/' . $product_slug  ?>">
											<?= Html::img('@web/'.$product_arr[$item->product_id]['img'], ['style' => 'height: 50px;']) ?>
										</a>
									</td>
									<td style="vertical-align: middle;">
										<?= Html::a( $product_name . ' <span>'.$combination.'</span>', ['/products/' . $product_category . '/' . $product_slug ], []) ?>
									</td>
									<td style="vertical-align: middle;">
										<input type="number" value="<?= $item->amount ?>" class="form-control product-amount" min="<?= $product_arr[$item->product_id]['min_order'] ?>" max="<?= $max ?>" step="<?= $product_arr[$item->product_id]['min_order'] ?>">
									</td>
									<td style="vertical-align: middle;">
										<span class="app-update-cart"><i class="fa fa-refresh"></i></span>
									</td>
									<td style="vertical-align: middle;"><?= $price ?></td>
									<td style="vertical-align: middle;"><?= $price*$item->amount ?></td>
									<td style="vertical-align: middle;">
										<span data-cart="<?= $item->id ?>" class="app-delete-from-cart"><i class="fa fa-trash-o"></i></span>
									</td>
								</tr>

							<?php endforeach; ?>

						</tbody>
						<tfoot>
							<tr>
								<th colspan="5"><?= Yii::t('app', 'Total sum in cart') ?></th>
								<th colspan="2"><?= $total ?> <?= Price::getCurrency() ?></th>
							</tr>
						</tfoot>
					</table>

					<?php Pjax::end(); ?>

				</div>

				<div class="box-footer">
					<div>
						<div class="">
							<?= Html::a('<i class="fa fa-angle-left"></i> '.Yii::t('app', 'Continue shopping'), ['/'], ['class' => 'btn btn-default']) ?>
							<?= Html::a(Yii::t('app', 'Перейти к оформлению покупки') .' <i class="fa fa-angle-right"></i>', ['/order/create'], ['class' => 'btn btn-app-default pull-right']) ?>
						</div>
					</div>

				</div>


			</div><!--/.box-->

		</div><!-- /.col-md-9 -->

		<div class="col-md-3">

		</div><!--/.col-md-3-->

	</div>
</div>