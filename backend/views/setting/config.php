<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

$this->registerJsFile('@web/js/setting.js');

$this->title = Yii::t('app', 'Variables');

?>

<?php Pjax::begin([
    'id' => 'app-configs'
]); ?>

<table class="table table-striped table-bordered" id="app-site-setting-table">
	<thead>
		<tr>
			<th><?= Yii::t('app', 'Code') ?></th>
			<th><?= Yii::t('app', 'Key') ?></th>
			<th><?= Yii::t('app', 'Value') ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($model as $key => $value): ?>
			<tr>
				<td class="app-code"><?= $key ?></td>
				<td class="app-title"><?= $value->title ?></td>
				<td class="app-content"><?= $value->content ?></td>
				<td>
					<span class="btn btn-info app-set-edit" title="<?= Yii::t('app', 'Edit') ?>">
						<i class="fa fa-edit"></i>
					</span>
					<span class="btn btn-danger app-set-del" title="Yii::t('app', 'Delete')">
						<i class="fa fa-trash"></i>
					</span>
				</td>
			</tr>
		<?php endforeach; ?>		
	</tbody>	
</table>

<?php Pjax::end(); ?>

<div class="row">
	<div class="col-md-12">
		
		<div class="add-new-body" style="margin-bottom: 30px;">
			<a class="btn btn-success" id="app-add-set"><i class="fa fa-plus"></i> <?= Yii::t('app', 'Add') ?></a>
		</div>

	</div>
</div>

<?php Modal::begin([
	'header' => '<h4>' . Yii::t('app', 'New variable') . '</h4>',
	'id' => 'app-add-set-modal',
	'size' => 'modal-md',
]); ?>

<div id='app-add-set-modal-content'>
	<form id="form-app-add-set">

		<div class="row">
			<div class="col-md-4">
				<div class="form-group required">
					<label class="control-label" for="app-set-code"><?= Yii::t('app', 'Code') ?></label>
					<input required type="text" id="app-set-code" class="form-control" name="" maxlength="100">
				</div>								
			</div>
			<div class="col-md-4">
				<div class="form-group required">
		        	<label class="control-label" for="app-set-title"><?= Yii::t('app', 'Key') ?></label>
		        	<div class="input-group">
		        		<input required type="text" id="app-set-title" class="form-control" name="">
		        	</div>
				</div>								
			</div>
			<div class="col-md-4">
				<div class="form-group required">
					<label class="control-label" for="app-set-content"><?= Yii::t('app', 'Value') ?></label>
					<input required type="text" id="app-set-content" class="form-control" name="" maxlength="100">
				</div>								
			</div>
			<div id="app-add-set-message" style="color:red;"></div>
		</div>
		<div>
			<button class="btn btn-app-default" type="submit" id="app-add-set-submit"><?= Yii::t('app', 'Save') ?></button>
		</div>									
	</form>
</div>

<?php Modal::end(); ?> 

<div class="well">

    <p> Вставить переменную: <code> \common\models\Configs::byCode('код')</code></p>

 </div>