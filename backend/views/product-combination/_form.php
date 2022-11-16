<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\file\FileInput;

use backend\models\AttributeList;
use backend\models\AttributeValue;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCombination */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-combination-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => $model->formName(),
	]); ?>

   	<div class="row">

   		<div class="col-md-6">

            <?= $form->field($model, 'kode'); ?>

		    <?= $form->field($model, 'attribute_id')->dropDownList(
		        ArrayHelper::map(AttributeList::find()->all(), 'id', 'name_' . Yii::$app->language ),
		        ['prompt'=> '-- ' . Yii::t('app', 'Select a attribute') . ' --',
				'onchange'=>'
					$.post( "'.Yii::$app->urlManager->createUrl('attribute-value/values?id_attr=').'"+$(this).val(), function( data ) {
					  $( "select#productcombination-attribute_value_id" ).html( data );
					});
				'
				]
		    ) ?>

		    <?= $form->field($model, 'attribute_value_id')->dropDownList(
		        ['prompt'=> '-- ' . Yii::t('app', 'Select a value') . ' --']
		    ) ?>


			<?php if(!$model->isNewRecord): ?>
				<script>
					// при редактировании выставить по умолчанию атрибут в селекте
					function attributeLoad() {
						$.post( "/admin/attribute-value/values?id_attr="+$('select#productcombination-attribute_id' ).val(), function( data ) {
						  $( "select#productcombination-attribute_value_id" ).html( data );
						  $("select#productcombination-attribute_value_id [value='<?= $model->attribute_value_id ?>']").attr("selected", "selected");
						  console.log(data);
						});
					}

					attributeLoad();
				</script>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-6">

					<?= $form->field($model, 'quantity', [
						'template' => '
							{label}
							<div class="input-group">
								<span class="input-group-addon counter-plus"><i class="fa fa-plus"></i></span>
								{input}'.
								'<span class="input-group-addon counter-minus"><i class="fa fa-minus"></i></span>
							</div>
							{error}
						',
					]); ?>

				</div>
			</div>

			<div class="row">

				<div class="col-md-6">
					<?php // $form->field($model, 'sort_position')->textInput() ?>

					<?= $form->field($model, 'sort_position', [
						'template' => '
							{label}
							<div class="input-group">
								<span class="input-group-addon counter-plus"><i class="fa fa-plus"></i></span>
								{input}'.
								'<span class="input-group-addon counter-minus"><i class="fa fa-minus"></i></span>
							</div>
							{error}
						',
					]); ?>

				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'default_check')->checkbox() ?>
				</div>
			</div>

			<?php // $form->field($model, 'quantity')->textInput() ?>

			<?php // $form->field($model, 'reserve')->textInput() ?>

			<?php // $form->field($model, 'date_create')->textInput() ?>

			<?php // $form->field($model, 'parent_id')->textInput() ?>

			<?= $form->field($model, 'status')->checkbox() ?>


			<?php // $form->field($model, 'buy')->textInput() ?>

            <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'price', [
                            'template' => '
                                {label}
                                <div class="input-group">
                                    <span class="input-group-addon counter-plus"><i class="fa fa-plus"></i></span>
                                    {input}'.
                                    '<span class="input-group-addon counter-minus"><i class="fa fa-minus"></i></span>
                                </div>
                                {error}
                            ',
                        ]); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'price_old', [
                            'template' => '
                                {label}
                                <div class="input-group">
                                    <span class="input-group-addon counter-plus"><i class="fa fa-plus"></i></span>
                                    {input}'.
                                    '<span class="input-group-addon counter-minus"><i class="fa fa-minus"></i></span>
                                </div>
                                {error}
                            ',
                        ]); ?>
                    </div>
                </div>


   		</div>

   		<div class="col-md-6">
			<?php
				if (!$model->isNewRecord && $model->img != '') {
					echo Html::img('../../frontend/web/' . $model->img, ['style' => 'height:250px;']);
				}
			?>
			<?= $form->field($model, 'fileimg')->widget(FileInput::classname(), [
					'pluginOptions' => [
						'showRemove' => false,
						'showUpload' => false,
						'browseClass' => 'btn btn-primary btn-block',
						//'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
						'browseLabel' =>  Yii::t('app', 'Select image') .'...'
					],
					'options' => ['accept' => 'image/*']
				])

			?>
   		</div>

   	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function() {
        var options = {
            //target: '#realtions_images',   // target element(s) to be updated with server response
            beforeSubmit:  showRequest,  // pre-submit callback
            success:       showResponseCombination,  // post-submit callback

            //url: $('form#ProductImages').attr("action"),               // override for form's 'action' attribute
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type)
            //clearForm: true,        // clear all form fields after successful submit
            //resetForm: true,        // reset the form after successful submit
        };

        $('form#ProductCombination').on('beforeSubmit', function(e) {
            $(this).ajaxSubmit(options);
            console.log('start');
            return false;
            console.log('after false');
        });
    });

     function showRequest(formData, jqForm, options) {
         var queryString = $.param(formData);

         console.log(queryString);
         console.log(jqForm);
         console.log(options);
         return true;
     }

    // post-submit callback
    function showResponseCombination(responseText, statusText, xhr, $form)  {
        if (responseText == true) {
            $(document).find('#modal_combination').modal('hide');
            $('form#ProductCombination').trigger("reset");
            $("#modalCombinationMessage").html('');
            $.pjax.reload({container: '#product_combinations'});
            $.notify("Successfully created", "success");
        } else {
            $.notify("Error", "error");
        }
        console.log('status: ' + statusText + '\n\nresponseText: \n' + responseText);
		console.log(xhr);
		console.log($form);
    }
</script>
