<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AttributeList;

/* @var $this yii\web\View */
/* @var $model backend\models\RelationsProductAtribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relations-product-atribute-form">

    <?php $form = ActiveForm::begin([
    	'id' => $model->formName(),
    ]); ?>

    <?php // $form->field($model, 'product_id')->textInput() ?>
    
    <?= $form->field($model, 'attribute_id')->dropDownList(
        $model->getAttributesFoCategory(),
        ['prompt'=> '-- ' . Yii::t('app', 'Select a attribute') . ' --',
		'onchange'=>'
			$.post( "'.Yii::$app->urlManager->createUrl('attribute-value/values?id_attr=').'"+$(this).val(), function( data ) {
			  $( "select#relationsproductatribute-attribute_value_id" ).html( data );
			});
		'
		]
    ) ?>

    <?= $form->field($model, 'attribute_value_id')->dropDownList(
        ['prompt'=> '-- ' . Yii::t('app', 'Select a value') . ' --']
    ) ?>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
	// создание нового аттрибута через pjax

	$('form#RelationsProductAtribute').on('beforeSubmit', function(e)
	{
		var $form = $(this);

		$.post (
			$form.attr("action"),
			$form.serialize()
		)
			.done (function(result) {
				console.log(result);
				if (result == true) {
					$(document).find('#modal_attribute').modal('hide');
					$($form).trigger("reset");
					$("#modalAttrMessage").html('');
					$.pjax.reload({container: '#realtions_attribute'});
		            $.notify("Successfully created", "success");
		        } else {
					$.notify("Error", "error");
					$("#modalAttrMessage").html(result);
				}
			}).fail(function() {
				console.log("server error");
			});
		return false;
	});	
</script>