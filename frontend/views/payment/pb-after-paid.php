<?php

use yii\helpers\Html;

use common\models\Price;

$this->title = '#' . $order->code . " Success";

?>

<div class="container">
    
    <div class="row box">

        <div class="col-md-12">

            <h1><?= Yii::t('app', 'Order') ?> #<?= $order->code ?></h1>
            <hr>
            
            <div class="">

                <div class="alert alert-success" role="alert">
                    
                    <div class="media">
                      <div class="media-left media-middle">
                        <i class="fa fa-check fa-5x"></i>
                      </div>
                      <div class="media-body">
                        <p  style="font-size: 36px;"><?= Yii::t('app', 'Order') ?> #<?= $order->code ?> - <?= $order->total_sum ?> <?= Price::getCurrency() ?> <?= Yii::t('app', 'well paid') ?></p>
                      </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="">
            <div style="text-align: right;">
                <div class="form-group" style="margin-bottom: 0px;">
                    <?= Html::a('<i class="fa fa-chevron-left"></i> ' . Yii::t('app', 'Continue shopping'), ['/products'], ['class' => 'btn btn-app-default']) ?>
                </div>
            </div>
        </div>        
        
    </div>

</div>