<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\AttributeList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="attribute-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'name_' . Yii::$app->language, [
                'template' => '
                    {label}
                    <div class="input-group">
                        {input}'.
                        '<span class="btn-other-name-attribute-list input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
                    </div>
                    {error}
                ',
            ]); ?>
    
            <div class="row other-name-attribute-list" style="display:none;">
                <div class="col-md-12">
                    <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                        <?php if ($key == Yii::$app->language) {
                            continue;
                        } ?>

                            <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>

                    <?php endforeach; ?>                                  
                </div>
            </div>

            <?= $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::map(Category::find()->all(), 'id', 'name_' . Yii::$app->language ),
                ['prompt'=> '-- ' . Yii::t('app', 'Common') . ' --']
            ) ?>

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

            <?= $form->field($model, 'as_filter')->checkbox() ?>      

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
