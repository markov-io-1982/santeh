<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$width = 300;
$height = 320;
$max_width = 300;
$alt_text = 'img';
$image_source = '..\..\frontend\web\images\logo.jpg';

?>

<?= \cozumel\cropper\ImageCropper::widget(['id' => 'user_profile_photo']); ?>

<img width="<?= $width; ?>" height="<?= $height; ?>" max-width="<?=$max_width;?>" class="border" id="user_profile_photo" alt="<?= $alt_text;?>" src="<?= $image_source; ?>">

<div style="display:none;" id="js_photo_preview">
  <strong>Preview:</strong>
    <div class="p_2">
      <div id="js_profile_photo_preview_container" style="position:relative; overflow:hidden; width:75px; height:75px; border:1px #000 solid;">
        <img width="<?= $width; ?>" height="<?= $height; ?>" class="border" id="js_profile_photo_preview" alt="<?=$alt_text;?>" src="<?= $image_source; ?>" style="">
      </div>        
  </div>
</div>

<?php
$form = ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['site/crop']), 'options' => ['id' => 'crop_form'],
]);
?>
	<div><input type="hidden" id="x1" value="" name="x1"></div>
	<div><input type="hidden" id="y1" value="" name="y1"></div>
	<div><input type="hidden" id="x2" value="" name="x2"></div>
	<div><input type="hidden" id="y2" value="" name="y2"></div>
	<div><input type="hidden" id="w" value="" name="w"></div>
	<div><input type="hidden" id="h" value="" name="h"></div>
	<div><input type="hidden" value="<?= $width; ?>" name="image_width"></div>
	<div><input type="hidden" value="<?= $height; ?>" name="image_height"></div>
	<div><input type="hidden" value="<?= $image_source; ?>" name="image_source"></div>               
	<div style="margin-top:10px;">
	<input type="submit" class="button" id="js_save_profile_photo" value="Save Avatar">
	</div>

<?php ActiveForm::end(); ?>