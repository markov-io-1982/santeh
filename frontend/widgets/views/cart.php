<?php

use yii\helpers\Html;
use common\models\Price;

?>

<div class="cart-panel panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">
		<i class="fa fa-shopping-cart"></i> <?= Yii::t('app', 'Cart') ?>
	</div>
	<div class="panel-body">
		
		<div class="table-responsive">
			<table class="table">
			<tbody>
				<tr>
					<td><?= Yii::t('app', 'Количество') ?>:</td>
					<th><span class="app-count-product-in-cart">0</span> </th>
				</tr>
				<tr>
					<td><?= Yii::t('app', 'Total sum') ?>:</td>
					<th><span class="app-total-sum-in-cart">0</span> <?= Price::getCurrency() ?></th>
				</tr>
			</tbody>
			</table>			
		</div>

		<div>
			<?= Html::a('<i class="fa fa-shopping-cart"></i> '. Yii::t('app', 'Commit buy'), ['/cart/index'], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Commit buy')]) ?>
		</div>
	</div>
</div>