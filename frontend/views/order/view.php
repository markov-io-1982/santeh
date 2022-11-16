<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Order */

$name = 'name_'.Yii::$app->language;

$this->title = Yii::t('app', 'Заказ') . ' #' . $model->code;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    
    <div class="order-view">

        <div class="row">
            
            <div class="col-md-12">

                <div class="box ">

                    <h1><?= Html::encode($this->title) ?></h1>

                    <hr>

                    <div>

                        <div class="alert alert-success">
                            <div class="row">
                                <div class="col-lg-2">
                                    <i style="color:green;" class="fa fa-check-square-o fa-5x"></i>
                                </div>
                                <div class="col-lg-8" style="font-size: 26px;">
                                    <?= Yii::t('app', 'Your order is successfully issued. Wait until the administrator will contact you. Thank you.'); ?>
                                </div>
                            </div>                            
                        </div>

                    </div>

                    <div class="order-detail">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><?= Yii::t('app', 'Full name') ?></td>
                                    <th><?= $model->user_lastname ?> <?= $model->user_name ?> <?= $model->user_middlename ?></th>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'E-mail') ?></td>
                                    <th><?= $model->user_email ?></th>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Phone') ?></td>
                                    <th><?= $model->user_phone ?></th>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Payment Metod') ?></td>
                                    <th><?= \backend\models\PaymentMethod::findOne(['id' => $model->payment_metod_id])->$name ?></th>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Delivery Method') ?></td>
                                    <th><?= \backend\models\DeliveryMethod::findOne(['id' => $model->delivery_method_id])->$name ?></th>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Address') ?></td>
                                    <th><?= $model->user_adress ?></th>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Total sum') ?></td>
                                    <th style="font-size: 26px;"><?= $model->total_sum ?> <?= \common\models\Price::getCurrency() ?></th>
                                </tr>
                            </tbody>                            
                        </table>
                    </div>


                    <div class="box-footer">

                        <div class="text-center">

                        <?php if ($model->payment_metod_id == 2): ?>
                            <?= Html::a (Yii::t('app', 'Оплатить через WebMoney'), ["payment/wmpayform", 'id' => $model->id ], ["title" => Yii::t('app', 'Оплатить заказ через WebMomey'), "class" => "btn btn-app-default" ] ) ?>
                        <?php endif; ?>

                        <?php if($model->payment_metod_id == 1): ?>
                            <?= Html::a (Yii::t('app', 'Оплатить через Privat24'), ["payment/pb-paid-form", 'id' => $model->id ], ["title" => Yii::t('app', 'Оплатить заказ через Privat24'), "class" => "btn btn-app-default" ] ) ?>
                        <?php endif; ?>

                        <?php if($model->payment_metod_id != 1 && $model->payment_metod_id != 2): ?>
                            <?= Html::a(Yii::t('app', 'Continue shopping') . ' <i class="fa fa-chevron-right"></i>', ['/products'], ['class' => 'btn btn-app-default', 'style' => 'font-weight:bold;']) ?>
                        <?php endif; ?>

                        </div>
                            
                    </div>

                </div>
                
            </div>

        </div>

    </div>

</div>

