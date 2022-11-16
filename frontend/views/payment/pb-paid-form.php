<?php

use frontend\models\PaymentPb;
use common\models\Price;
use frontend\models\S;

$this->title = Yii::t('app', 'Order') . '#'. $order->code;

?>

<div class="container">
	
	<div class="row box">
		
		<div class="col-sm-12">

			<h1><?= $this->title ?></h1>
			<hr>

			<div class="alert alert-info" role="alert">
				<div class="row">
					<div class="col-sm-2">
						<i class="fa fa-money fa-5x"></i>
					</div>
					<div class="col-sm-10">
						<p>Оплата заказа <strong>#<?= $order->code ?></strong></p>
						<p>Способ оплаты <strong>Приват24</strong></p>
						<p>Сумма заказа <strong><?= $order->total_sum ?> грн.</strong></p>
					</div>
				</div>
			</div>
			
			<form method="POST" action="https://api.privatbank.ua/p24api/ishop">
				<input type="hidden" name="amt" value="<?= $order->total_sum ?>" />						<!-- Сумма -->
				<input type="hidden" name="ccy" value="UAH" />											<!-- Валюта -->
				<input type="hidden" name="merchant" value="<?= S::getCont('pb_merchant') ?>" />		<!-- ID Мерчанта -->
				<input type="hidden" name="order" value="<?= $order->code ?>" />						<!-- Код товара/платежа -->
				<input type="hidden" name="details" value="Оплата заказа #<?= $order->code ?>" />		<!-- Назначение платежа -->
				<input type="hidden" name="ext_details" value="Оплата заказа #<?= $order->code ?> на сумму <?= $order->total_sum ?>" />					<!-- Дополнительная информация (можно оставить пустым) -->
				<input type="hidden" name="pay_way" value="privat24" />				<!-- Способ оплаты -->
				<input type="hidden" name="return_url" value="http://<?= $_SERVER['HTTP_HOST'] ?>/payment/pb-after-paid?id=<?= $order->id ?>" /> 	<!-- Страница, принимающая клиента после оплаты -->
				<input type="hidden" name="server_url" value="http://<?= $_SERVER['HTTP_HOST'] ?>/payment/pb-paid" />			<!-- URL ответа -->
				<button class="btn btn-app-default" type="submit"><?= Yii::t('app', 'Pay') ?> <?= $order->total_sum ?> <?= Price::getCurrency() ?></button>
			</form>

		</div>

	</div>

</div>