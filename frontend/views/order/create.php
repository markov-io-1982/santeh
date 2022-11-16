<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\DeliveryMethod;
use backend\models\PaymentMethod;
use backend\models\OrderStatus;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\Pjax;

use common\models\Price;

/* @var $this yii\web\View */
/* @var $model frontend\models\Order */

$this->title = Yii::t('app', 'Оформление заказа');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">


	<div class="row">
		
		<div class="col-md-9">

			<div class="box order-create">

			    <h1><?= Html::encode($this->title) ?></h1>

			    <hr>

				<div class="order-form">

	                <?php $form = ActiveForm::begin(); ?>

	                <div class="row">
	                	
						<div class="col-md-8">
							
							<div class="row">
								<div class="col-md-6">
									<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'user_middlename')->textInput(['maxlength' => true]) ?>
								</div>
								
								<div class="col-md-12">
									<?= $form->field($model, 'user_lastname')->textInput(['maxlength' => true]) ?>								
								</div>

							</div>

							<div class="row">
								<div class="col-md-6">
									<?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'user_phone', [
								        'template' => '
								        	{label}
								        	<div class="input-group">
								        		<span class="input-group-addon">+38</span>
								        		{input}
								        	</div>
								        	{error}',
								    ]); ?>
								</div>
							</div>

						</div>

						<div class="col-md-4">

				            <?= $form->field($model, 'payment_metod_id')->dropDownList(
				                ArrayHelper::map(PaymentMethod::find()->all(), 'id', 'name_' . Yii::$app->language ),
				                ['prompt'=> '-- ' . Yii::t('app', 'Select a payment method') . ' --']
				            ) ?>

				            <?= $form->field($model, 'delivery_method_id')->dropDownList(
				                ArrayHelper::map(DeliveryMethod::find()->all(), 'id', 'name_' . Yii::$app->language ),
				                ['prompt'=> '-- ' . Yii::t('app', 'Select a delivery method') . ' --']
				            ) ?>

				            <?php // $form->field($model, 'user_adress')->textInput(['maxlength' => true]) ?>

				            <?php // $form->field($model, 'user_adress')->dropDownList (
							//		\common\models\NovaPoshta::getSitiesNP(),
		             		//	 ['prompt' => '-- Выберите адрес отделения --', "style" => ""]
	   						// ) ?>

							<p style="margin-bottom: 5px; font-weight: 800;"><?= Yii::t('app', 'Adress') ?></p>
							<div class="np" style="display:none;">
								<?php

									echo $form->field($model, 'np', [
						        'template' => '
						        	<div class="">
						        		{input}
						        	</div>
						        	{error}',
							])->widget(Select2::classname(), [
									    'data' => \common\models\NovaPoshta::getSitiesNP(),
									    'options' => ['placeholder' => Yii::t('app', '--Select a department--')],
									    'language' => Yii::$app->language,
									    'pluginOptions' => [
									        'allowClear' => true
									    ],

									]);

								?>								
							</div>


							<?= $form->field($model, 'user_adress', [
						        'template' => '
						        	<div class="">
						        		{input}
						        	</div>
						        	{error}',
							])->textInput(['maxlength' => true, 'style' => 'display:none']) ?>

							<div id="of_adrs" style="display:none">
								<p><?= \frontend\models\S::getCont('office_adress') ?></p>
							</div>

							<script type="text/javascript">

								$(document).ready(function (){

									/* отфильтровать способы доставки в зависимостти от способов оплаты */
									var payment_method = $('select#order-payment_metod_id');

									payment_method.change(function (){
										if(payment_method.val() == 3) {	// оплата Наложенный платеж Новая почта
											$('#order-delivery_method_id>option').hide();
											$('#order-delivery_method_id>option[value=1]').show();
											$("#order-delivery_method_id [value='1']").attr("selected", "selected");
											$('.np').css('display', 'block');
											$('#order-user_adress').css('display', 'none');
											$('#of_adrs').css('display', 'none');
										} else if (payment_method.val() == 4) {	// оплата Наложенный платеж Укрпочта
											$('#order-delivery_method_id>option').hide();
											$('#order-delivery_method_id>option[value=2]').show();
											$("#order-delivery_method_id [value='2']").attr("selected", "selected");
											$('.np').css('display', 'none');
											$('#order-user_adress').css('display', 'block');
											$('#of_adrs').css('display', 'none');
										} else if (payment_method.val() != 3 && payment_method.val() != 4) { // оплата любым способом кроме Наложенный платеж Новая почта и Наложенный платеж Укрпочта
											$('#order-delivery_method_id>option').show();
											$("#order-delivery_method_id :first").attr("selected", "selected");
											$('.np').css('display', 'none');
											$('#order-user_adress').css('display', 'none');
											$('#of_adrs').css('display', 'none');
										}
									});	


									var elem = $('select#order-delivery_method_id');

									if (elem.val() == 1) {					// доставка Новая почта
										$('.np').css('display', 'block');
									}

									else if (elem.val() == 3) {				// самовывоз
										$('#of_adrs').css('display', 'block');
									}

									else if ( elem.val() != 1 && elem.val() != 3 && elem.val() != '' ) {
										$('#order-user_adress').css('display', 'block');
									}

									elem.change(function (){
										if ( elem.val() == '1' ) {
											$('.np').css('display', 'block');
											$('#order-user_adress').css('display', 'none');
											$('#of_adrs').css('display', 'none');
										}
										else if (elem.val() == '3') {
											$('#of_adrs').css('display', 'block');
											$('#order-user_adress').css('display', 'none');
											$('.np').css('display', 'none');		
										}
										else if (elem.val() == '') {
											$('.np').css('display', 'none');
											$('#order-user_adress').css('display', 'none');
											$('#of_adrs').css('display', 'none');
										}
										else {
											$('.np').css('display', 'none');
											$('#of_adrs').css('display', 'none');
											$('#order-user_adress').css('display', 'block');
										}
									});	
								});


							</script>


						</div>

	                </div>

	                <div class="row">
	                	<div class="col-md-12">
	                		<?= $form->field($model, 'user_comment')->textInput(['maxlength' => true]) ?>
	                	</div>
	                </div>

					<div class="box-footer">
						<div style="text-align: right;">
					        <div class="form-group" style="margin-bottom: 0px;">
					            <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('app', 'Confirm order'), ['class' => 'btn btn-app-default']) ?>
					        </div>
						</div>
					</div>

	                <?php ActiveForm::end(); ?>
		                

				</div>

			</div>
			
		</div>

		<div class="col-md-3">
			
            <div class="box">
                
                <div class="box-header">
                	<?= Yii::t('app', 'Order summary') ?>
                </div>

				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td><?= Yii::t('app', 'Total amount') ?></td>
								<th><?= $data['total_amount'] ?></th>
							</tr>
							<tr>
								<td><?= Yii::t('app', 'Total sum') ?></td>
								<th><?= $model->total_sum ?> <?= Price::getCurrency(); ?></th>
							</tr>
						</tbody>
					</table>
				</div>
				

            </div>

		</div>

	</div>
	
</div>

