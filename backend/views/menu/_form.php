<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Menu;
/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_' . Yii::$app->language, [
        'template' => '
            {label}
            <div class="input-group">
                {input}'.
                '<span class="btn-other-name input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
            </div>
            {error}
        ',
    ]); ?>

    <div class="row other-name" style="display:none;">
        <div class="col-md-12">
            <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                <?php if ($key == Yii::$app->language) {
                    continue;
                } ?>

                    <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>

            <?php endforeach; ?>                                  
        </div>
    </div>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(Menu::find()->all(), 'id', 'name_' . Yii::$app->language ),
        ['prompt'=> '-- ' . Yii::t('app', 'Main level') . ' --']
    ) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
