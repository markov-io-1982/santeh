<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\RelationsProductProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relations-product-product-form">

    <?php $form = ActiveForm::begin([
    	'id' => $model->formName(),
    ]); ?>

	<div class="form-group">
		<label class="control-label" for="product_category"><?= Yii::t('app', 'Select a category') ?></label>
		<?= Html::dropDownList('categoy', 'id', ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name_' . Yii::$app->language ), [
	            'prompt' => '-- ' . Yii::t('app', 'Select a category') . ' --',
	            'class' => 'form-control',
	            'id' => 'product_category',
				'onchange'=>'
					$.post( "'.Yii::$app->urlManager->createUrl('product/get-product-by-catrgory?id=').'"+$(this).val(), function( data ) {
					  $( "select#relationsproductproduct-product_rel_id" ).html( data );
					});'
			])
		?>		
	</div>


    <?= $form->field($model, 'product_rel_id')->dropDownList(
        ArrayHelper::map(Product::find()->all(), 'id', 'name_' . Yii::$app->language ),
        ['prompt'=> '-- ' . Yii::t('app', 'Select a product') . ' --']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
	// отправка формы связаного продукта через pjax

	$('form#RelationsProductProduct').on('beforeSubmit', function(e)
	{
		var $form = $(this);

		$.post (
			$form.attr("action"),
			$form.serialize()
		)
			.done (function(result) {
				console.log(result);
				if (result == true) {
					$(document).find('#modal_product').modal('hide');
					$($form).trigger("reset");
					$("#modalMessage").html('');
//					$.pjax.reload({container: '#realtions_product'});
					$.pjax({container: '#realtions_product', timeout: 0});
				}
				else {
					$("#modalMessage").html(result);
				}
			}).fail(function() {
				console.log("server error");
			});
		return false;
	});	
</script>