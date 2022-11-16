<?php

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\models\Cart;
use backend\models\DeliveryMethod;
use backend\models\PaymentMethod;
use backend\models\OrderStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'total_sum')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'delivery_method_id')->dropDownList(
                ArrayHelper::map(DeliveryMethod::find()->all(), 'id', 'name_' . Yii::$app->language ),
                ['prompt'=> '-- ' . Yii::t('app', 'Select a delivety method') . ' --']
            ) ?>

            <?= $form->field($model, 'user_adress')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'payment_metod_id')->dropDownList(
                ArrayHelper::map(PaymentMethod::find()->all(), 'id', 'name_' . Yii::$app->language ),
                ['prompt'=> '-- ' . Yii::t('app', 'Select a payment method') . ' --']
            ) ?>

            <?= $form->field($model, 'date_create')->textInput() ?>

            <?= $form->field($model, 'date_payment')->textInput() ?>

            <?= $form->field($model, 'order_status_id')->dropDownList(
                ArrayHelper::map(OrderStatus::find()->all(), 'id', 'name_' . Yii::$app->language ),
                ['prompt'=> '-- ' . Yii::t('app', 'Select a order status') . ' --']
            ) ?>

        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_middlename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'user_comment')->textInput(['maxlength' => true]) ?>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!--
<div>
    <h2>Продукты в заказе</h2>
<?php

$dataProvider = new ActiveDataProvider([
    'query' => Cart::find()
        ->select(['id', 'product_id', 'amount', 'price'])
        ->where(['order_id' => $model->id]),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'product',
                'header'=>'Продукт',
                //'value' => 'product.name_'.Yii::$app->language,
                'value' => function($model) {
                    $name = $model->product['name_'.Yii::$app->language];
					return $name;
	            },
                'filter'=>false,
            ],
            [
                'attribute'=>'product.kod',
                'header'=>'Арт',
                'value' => 'product.kode',
                'filter'=>false,
            ],
            //'product_id',
            'amount',
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = \yii\helpers\Url::to(['/product/view', 'id' => $model->product_id]);
                        return Html::a(
                        '<i class="fa fa-eye"></i>', $url, ['class' => 'btn btn-default', 'title' => Yii::t('app', 'View')]);
                    },
                ],
            ],
        ],
    ]);
?>

</div>
-->