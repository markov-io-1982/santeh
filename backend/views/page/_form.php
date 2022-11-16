<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#genelar_information" data-toggle="tab"><?= Yii::t('app', 'General information') ?></a></li>
            <li><a href="#description" data-toggle="tab"><?= Yii::t('app', 'Description') ?></a></li>
            <li><a href="#seo" data-toggle="tab"><?= Yii::t('app', 'SEO') ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="genelar_information">

                <div class="row">
                    <div class="col-md-6">
                        
                        <?= $form->field($model, 'name_' . Yii::$app->language, [
                            'template' => '
                                {label}
                                <div class="input-group">
                                    {input}'.
                                    '<span class="btn-other-name-page input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
                                </div>
                                {error}
                            ',
                        ]); ?>

                        <div class="row other-name-page" style="display:none;">
                            <div class="col-md-12">
                                <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                                    <?php if ($key == Yii::$app->language) {
                                        continue;
                                    } ?>

                                    <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>

                                <?php endforeach; ?>                                  
                            </div>
                        </div>

                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'status')->checkbox() ?>

                    </div>
                    <div class="col-md-6">
                        
                        <?= $form->field($model, 'fileimg')->widget(FileInput::classname(), [
                                'pluginOptions' => [
                                    'showRemove' => false,
                                    'showUpload' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                    //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    'browseLabel' =>  Yii::t('app', 'Select image') .'...'
                                ],
                                'options' => ['accept' => 'image/*']
                            ])

                        ?>

                        <?php 
                            if (!$model->isNewRecord && $model->img) {
                                echo $form->field($model, 'no_image')->checkbox();
                                echo Html::img('../../frontend/web/' . $model->img );
                            }
                        ?>

                    </div>
                </div>

            </div>
            <div class="tab-pane" id="description">

                <div class="row">
                    <div class="col-md-11">
                        <?= $form->field($model, 'page_body_' . Yii::$app->language)->widget(CKEditor::className(), [
                                'options' => ['rows' => 3],
                                'preset' => 'basic'
                            ]) ?>

                        <div class="other-page-body" style="display:none;">

                                <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                                    <?php if ($key == Yii::$app->language) {
                                        continue;
                                    } ?>

                                    <?= $form->field($model, 'page_body_' . $key)->widget(CKEditor::className(), [
                                            'options' => ['rows' => 3],
                                            'preset' => 'basic'
                                        ]) ?>

                                <?php endforeach; ?>                        
                    
                        
                        </div>                  
                    </div>
                    <div class="col-md-1">
                        <div class="btn-other-page-body">
                            <i class="fa fa-language fa-3x"></i>
                            <span>Body</span>
                        </div>
                        
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="seo">

                <?= $form->field($model, 'seo_title_' . Yii::$app->language, [
                    'template' => '
                        {label}
                        <div class="input-group">
                            {input}'.
                            '<span class="btn-other-seo-title-page input-group-addon" title="Other SEO Title"><i class="fa fa-language"></i></span>
                        </div>
                        {error}
                    ',
                ]); ?>
              
                <div class="row other-seo-title-page" style="display:none;">
                    <div class="col-md-12">
                        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                            <?php if ($key == Yii::$app->language) {
                                continue;
                            } ?>

                            <?= $form->field($model, 'seo_title_' . $key)->textInput(['maxlength' => true]) ?>

                        <?php endforeach; ?>                                  
                    </div>
                </div>  

                <?= $form->field($model, 'seo_description_' . Yii::$app->language, [
                    'template' => '
                        {label}
                        <div class="input-group">
                            {input}'.
                            '<span class="btn-other-seo-description-page input-group-addon" title="Other SEO Description"><i class="fa fa-language"></i></span>
                        </div>
                        {error}
                    ',
                ]); ?>
              
                <div class="row other-seo-description-page" style="display:none;">
                    <div class="col-md-12">
                        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                            <?php if ($key == Yii::$app->language) {
                                continue;
                            } ?>

                            <?= $form->field($model, 'seo_description_' . $key)->textInput(['maxlength' => true]) ?>

                        <?php endforeach; ?>                                  
                    </div>
                </div> 

                <?= $form->field($model, 'seo_keywords_' . Yii::$app->language, [
                    'template' => '
                        {label}
                        <div class="input-group">
                            {input}'.
                            '<span class="btn-other-seo-keywords-page input-group-addon" title="Other SEO Keywords"><i class="fa fa-language"></i></span>
                        </div>
                        {error}
                    ',
                ]); ?>
              
                <div class="row other-seo-keywords-page" style="display:none;">
                    <div class="col-md-12">
                        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

                            <?php if ($key == Yii::$app->language) {
                                continue;
                            } ?>

                            <?= $form->field($model, 'seo_keywords_' . $key)->textInput(['maxlength' => true]) ?>

                        <?php endforeach; ?>                                  
                    </div>
                </div>  

                <?= $form->field($model, 'canonical_url')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
