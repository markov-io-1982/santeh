<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Admin Panel');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Yii::t('app', 'Admin Panel') ?></h1>

        <p class="lead"><?= Yii::t('app', 'To get started, click on the left menu') ?></p>
    </div>

    <div class="row">
    	
		<div class="col-sm-12">
			<div class="well">
				<h4><span style="border-bottom: 1px solid #ddd;"><?= Yii::t('app', 'Legend') ?>:</span></h4>
				<p>
					<small title="<?= Yii::t('app', 'New reviews') ?>" class="label bg-blue">+2</small> - <?= Yii::t('app', 'New reviews') ?>
				</p>
				<p>
					<small title="<?= Yii::t('app', 'New orders') ?>" class="label bg-green">+5</small> - <?= Yii::t('app', 'orders with the status "New"') ?>
				</p>
				<p>
					<small title="<?= Yii::t('app', 'New paid orders') ?>" class="label bg-yellow">+2</small> - <?= Yii::t('app', 'orders with the status "Paid (not delivered)"') ?>
				</p>				
			</div>

		</div>

    </div>

</div>
