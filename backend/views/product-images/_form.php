<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-images-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => $model->formName(),
        //'enableAjaxValidation' => true // включаем аджакс валидацию формы в модальном окне
    ]); ?>
    
    <div class="row">
    	<div class="col-md-6">
			<?= $form->field($model, 'name_' . Yii::$app->language, [
				'template' => '
					{label}
					<div class="input-group">
						{input}'.
						'<span class="input-group-addon btn-other-name-img" title="Other name"><i class="fa fa-language"></i></span>
					</div>
					{error}
				',
			]); ?>
   	
			<div class="row other-name-img" style="display:none;">
				<div class="col-md-12">
					<?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

						<?php if ($key == Yii::$app->language) {
							continue;
						} ?>

							<?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>

					<?php endforeach; ?>                                  
				</div>
			</div> 
			
			<div class="row">
				<div class="col-md-4">
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
   					
    	</div>    	
    	<div class="col-md-6">
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
    </div><!-- /.row -->

 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>

    $(document).ready(function() { 
        var options = { 
            //target: '#realtions_images',   // target element(s) to be updated with server response 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:       showResponse,  // post-submit callback

            //url: $('form#ProductImages').attr("action"),               // override for form's 'action' attribute 
            //type:      type        // 'get' or 'post', override for form's 'method' attribute 
            dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type) 
            //clearForm: true,        // clear all form fields after successful submit 
            //resetForm: true,        // reset the form after successful submit 
        }; 

        $('form#ProductImages').on('beforeSubmit', function(e) {
        //$('form#ProductImages').submit(function() { 
            $(this).ajaxSubmit(options);
            console.log('start'); 
            return false;
            console.log('after false');             
        }); 
    });

    // function showRequest(formData, jqForm, options) { 
    //     var queryString = $.param(formData); 
        
    //     console.log('About to submit: \n\n' + queryString); 
    //     return true; 
    // } 

    // post-submit callback 
    function showResponse(responseText, statusText, xhr, $form)  {
        if (responseText == true) {
            $(document).find('#modal').modal('hide');
            $('form#ProductImages').trigger("reset");
            $("#modalImgMessage").html('');
            $.pjax.reload({container: '#realtions_images'});
            $.notify("Successfully created", "success");
        } else {
            $.notify("Error", "error");
        }
        console.log('status: ' + statusText + '\n\nresponseText: \n' + responseText); 
    }

</script>