<?php

use yii\helpers\Html;

use common\models\Price;

$this->title = '#' . $model->code . " fail";;

?>

<div class="container">
    
    <div class="row box">

        <div class="col-md-12">
            
            <div class="">

            	<h1><?= Yii::t('app', 'Order') ?> #<?= $model->code ?></h1>

            	<hr>

                <div class="alert alert-danger" role="alert">
                    
                    <div class="media">
                      <div class="media-left media-middle">
                        <i class="fa fa-times fa-5x"></i>
                      </div>
                      <div class="media-body">
                        <p><?= Yii::t('app', 'Order') ?> #<?= $model->code ?> - <?= $model->total_sum ?> <?= Price::getCurrency() ?> <?= Yii::t('app', 'not paid') ?></p>
                      </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="box-footer">
            <div style="text-align: right;">
                <div class="form-group" style="margin-bottom: 0px;">
					<?= Html::a('<i class="fa fa-chevron-left"></i> ' . Yii::t('app', 'Continue shopping'), ['/products'], ['class' => 'btn btn-app-default']) ?>
                </div>
            </div>
        </div>        
        
    </div>

</div>