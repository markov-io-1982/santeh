<?php
/**
 * Форма оплаты через WebMoney
 */

use common\models\Price;
use frontend\models\S;

$this->title = Yii::t('app', 'Payment');

?>

<div class="container">
	
	<div class="row box">
		
		<div class="col-md-12">
			
			<h1 class=''>Оплата заказа <strong>#<?php echo $order->code; ?></strong> на суму <strong><?php echo $order->total_sum; ?></strong> <?= Price::getCurrency() ?></h1>

			<hr>

			<?php // echo $status; ?>

			<?php if ($status == 1): ?>
				<div class="alert alert-success" role="alert">
					<p>Текущий заказ уже оплачен</p>
				</div>
			<?php endif; ?>

			<?php if ($status == 0): ?>

			<div class="form">
				<form action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
					<input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
					<input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $order->id; ?>">  <!-- номер заказа -->
					<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo $order->total_sum; ?>">  <!-- сума к оплате -->
					<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="<?php echo base64_encode('Заказ ' . $order->code); ?>"> <!-- название товара или услуги -->
					<input type="hidden" name="LMI_PAYEE_PURSE" value="<?= S::getCont('wm_purse') ?>"> <!-- кошелек на который производится олата -->
					<input id='submit_payment' class="btn btn-app-default" type="submit" value="<?= Yii::t('app', 'Pay order') ?> <?= $order->total_sum; ?> <?= Price::getCurrency() ?>">
				</form>
			</div>

			<?php endif; ?>

		</div>

	</div>

</div>
