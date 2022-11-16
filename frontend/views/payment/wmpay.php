<?php

use frontend\models\S;

//echo "YES";

if ($_POST['LMI_PREREQUEST'] == 1) {

	$order = \backend\models\Order::findOne(["id" => $_POST['order_id']]);
	$wm_payment = \common\models\PaymentWm::findOne(["order_id" => $_POST['order_id']]);

	if ($wm_payment->status == 1) {
		echo 'Ошибка: Заказ уже оплачен';
		exit;
	}

	if ($_POST['LMI_PAYEE_PURSE'] != S::getCont('wm_purse') ) { // проверят кошелек
	//if ($_POST['LMI_PAYEE_PURSE'] != 'U384933742777' ) { // проверят кошелек
		$wm_payment->note = 'Ошибка: Кошелек на который совершается оплата не является кошельком продавца!';
		$wm_payment->save();
		echo 'Ошибка: Кошелек на который совершается оплата не является кошельком продавца';
		exit;
	} else {
		$wm_payment->payee_purse = $_POST['LMI_PAYEE_PURSE'];
	}

	if ($_POST['LMI_PAYMENT_AMOUNT'] != $order->total_sum) {
		$wm_payment->note = 'Ошибка: Не верная сумма к оплате!';
		$wm_payment->save();
		echo 'Ошибка: Не верная сумма к оплате';
		exit;
	} else {
		$wm_payment->payment_amount = $_POST['LMI_PAYMENT_AMOUNT'];
	}

	$wm_payment->mode = $_POST['LMI_MODE'];
	$wm_payment->payer_purse = $_POST['LMI_PAYER_PURSE'];
	$wm_payment->payer_wm = $_POST['LMI_PAYER_WM'];
	$wm_payment->note = 'Совершенние оплаты пройшло!';
	$wm_payment->save();

	echo "YES";
	exit;
}

else if (isset($_POST['LMI_SYS_INVS_NO'])) {
	//$_POST['LMI_SYS_INVS_NO']
	$wm_payment = \common\models\PaymentWm::findOne(["order_id" => $_POST['order_id']]);
	$wm_payment->payment_no = $_POST['LMI_PAYMENT_NO'];
	$wm_payment->sys_invs_no = $_POST['LMI_SYS_INVS_NO'];
	$wm_payment->sys_trans_no = $_POST['LMI_SYS_TRANS_NO'];
	$wm_payment->sys_trans_date = date('Y-m-d H:i:s', strtotime($_POST['LMI_SYS_TRANS_DATE']));

	$secret_key = S::getCont('wm_secret_key');
	//$secret_key = 'qwe123';
	$key = 
		$_POST['LMI_PAYEE_PURSE'].			// Кошелек продавца
		$_POST['LMI_PAYMENT_AMOUNT'].		// Сумма платежа
		$_POST['LMI_PAYMENT_NO']. 			// Внутренний номер покупки продавца
		$_POST['LMI_MODE'].					// Флаг тестового режима
		$_POST['LMI_SYS_INVS_NO'].			// Внутренний номер счета в системе WebMoney Transfer
		$_POST['LMI_SYS_TRANS_NO'].			// Внутренний номер платежа в системе WebMoney Transfer
		$_POST['LMI_SYS_TRANS_DATE'].		// Дата и время выполнения платежа
		$secret_key.						// Secret Key
		$_POST['LMI_PAYER_PURSE']. 			// Кошелек покупателя
		$_POST['LMI_PAYER_WM']; 			// WMId покупателя

		//print_r($key);

	if ( strtoupper(hash('sha256', $key)) != $_POST['LMI_HASH'] ) {
		$wm_payment->note = 'Ошибка: при оплате возникла ошибка!';
		$wm_payment->save();
		echo 'Ошибка: при оплате возникла ошибка!';
		exit;
	}

	$wm_payment->note = 'Платеж успешно осуществлен!';
	$wm_payment->status = 1;
	$wm_payment->save();
}

else {
	echo "Error";
}

?>