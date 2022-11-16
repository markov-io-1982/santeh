<?php

use yii\helpers\Html;

use common\models\Price;

$this->title = '#' . $model->code . " Success";

?>

<div class="container">
    
    <div class="row box">

        <div class="col-md-12">

            <h1><?= Yii::t('app', 'Order') ?> #<?= $model->code ?></h1>
            <hr>
            
            <div class="">

                <div class="alert alert-success" role="alert">

                    <div class="row">
                        <div class="col-sm-2">
                            <i class="fa fa-check fa-5x"></i>
                        </div>
                        <div class="col-sm-10" style="font-size: 36px">
                            <?= Yii::t('app', 'Order') ?> #<?= $model->code ?> - <?= $model->total_sum ?> <?= Price::getCurrency() ?> <?= Yii::t('app', 'well paid') ?>
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