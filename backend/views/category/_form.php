<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Category;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use kartik\tree\TreeViewInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="category-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1" data-toggle="tab">
                    <?= Yii::t('app', 'Basic settings') ?>
                </a>
            </li>
            <li>
                <a href="#tab_2" data-toggle="tab">
                    <?= Yii::t('app', 'SEO') ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <div class="row">
                    <div class="col-md-12">

                        <?= $form->field($model, 'name_' . Yii::$app->language, [
                            'template' => '
                                    {label}
                                    <div class="input-group">
                                        {input}' .
                                '<span class="btn-other-name-category input-group-addon" title="Other name"><i class="fa fa-language"></i></span>
                                    </div>
                                    {error}
                                ',
                        ]); ?>

                        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>
                            <?php if ($key == Yii::$app->language) {
                                continue;
                            } ?>
                            <?= $form->field($model, 'name_' . $key)->textInput(['maxlength' => true]) ?>
                        <?php endforeach; ?>

                        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>
                            <?= $form->field($model, 'description_' . $key)->widget(CKEditor::className(), [
                                'clientOptions' => [
                                    'height' => '250px',
                                ],
                                'options' => [
                                    'rows' => 6,
                                ],
                                'preset' => 'full',
                            ]) ?>
                        <?php endforeach; ?>
                        <div class="col-md-4 block-tree">
                            <!--<button>Развернуть</button>-->
                            <div class="text" tabindex="0">
                                <ul class="catalog category-products">
                                    <?= \backend\widgets\MenuWidget::widget(['tpl' => 'tree']); ?>
                                </ul>
                            </div>
                        </div>
                        <?php $value = ($model->parent_id) ?  $model->parent_id : '0'; ?>
                        <?= $form->field($model, 'parent_id')->hiddenInput(['value'=> $value, 'id' => 'hidden_parent'])->label(false);?>
                        <div class="col-md-8 block-tree">
                            <div id="category-view"></div>
                        </div>

                    </div>
                </div>

                <!-- The block for add images for category -->
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'fileimg')->widget(FileInput::classname(), [
                            'pluginOptions' => [
                                'showRemove' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-primary btn-block',
                                //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' => Yii::t('app', 'Select image') . '...'
                            ],
                            'options' => ['accept' => 'image/*']
                        ])
                        ?>
                    </div>
                </div>
                <!--/The block for add images for category -->

                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'sort_position', [
                            'template' => '
                                    {label}
                                    <div class="input-group">
                                        <span class="input-group-addon counter-plus"><i class="fa fa-plus"></i></span>
                                        {input}' .
                                '<span class="input-group-addon counter-minus"><i class="fa fa-minus"></i></span>
                                    </div>
                                    {error}
                                ',
                        ]); ?>
                    </div>
                </div>

                <?= $form->field($model, 'status')->checkbox() ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                <!-- block seo title  -->
                <div class="tab-pane">
                    <div id="exTab1">
                        <ul class="nav nav-tabs">
                            <?php $i = 1;
                            foreach (Yii::$app->params['languages'] as $key => $language): ?>
                                <li <?= $i == 1 ? ' class="active"' : ''; ?>>
                                    <a href="#<?= $i ?>a" data-toggle="tab">Seo title <?= $key ?></a>
                                </li>
                                <?php $i++; endforeach; ?>
                        </ul>
                        <div class="tab-content clearfix">
                            <?php $j = 1;
                            foreach (Yii::$app->params['languages'] as $key => $language): ?>
                                <?php $active = ($j == 1) ? ' active' : '' ?>
                                <div class="tab-pane<?= $active ?>" id="<?= $j ?>a">
                                    <?= $form->field($model, 'seo_title_' . $key, [
                                        'template' => '
                                            {label}
                                            <div class="input-group">
                                                {input}' .
                                            '<span class="btn-other-seo-title-category input-group-addon" title="Other SEO Title"><i class="fa fa-language"></i></span>
                                            </div>
                                            {error}
                                        ',
                                    ]); ?>
                                </div>
                                <?php $j++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- /block seo title  -->
                <!-- block seo description  -->
                <div class="tab-pane">
                    <div id="exTab2">
                        <ul class="nav nav-tabs">
                            <?php $i = 1;
                            foreach (Yii::$app->params['languages'] as $key => $language): ?>
                                <li <?= $i == 1 ? ' class="active"' : ''; ?>>
                                    <a href="#<?= $i ?>b" data-toggle="tab">Seo description <?= $key ?></a>
                                </li>
                                <?php $i++; endforeach; ?>
                        </ul>
                        <div class="tab-content clearfix">
                            <?php $j = 1;
                            foreach (Yii::$app->params['languages'] as $key => $language): ?>
                                <?php $active = ($j == 1) ? ' active' : '' ?>
                                <div class="tab-pane<?= $active ?>" id="<?= $j ?>b">
                                    <?= $form->field($model, 'seo_description_' . $key, [
                                        'template' => '
                                            {label}
                                            <div class="input-group">
                                                {input}' .
                                            '<span class="btn-other-seo-title-category input-group-addon" title="Other SEO description"><i class="fa fa-language"></i></span>
                                            </div>
                                            {error}
                                        ',
                                    ]); ?>
                                </div>
                                <?php $j++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- /block seo description  -->
                <!-- block seo keywords  -->
                <div class="tab-pane">
                    <div id="exTab3">
                        <ul class="nav nav-tabs">
                            <?php $i = 1;
                            foreach (Yii::$app->params['languages'] as $key => $language): ?>
                                <li <?= $i == 1 ? ' class="active"' : ''; ?>>
                                    <a href="#<?= $i ?>c" data-toggle="tab">Seo keywords <?= $key ?></a>
                                </li>
                                <?php $i++; endforeach; ?>
                        </ul>
                        <div class="tab-content clearfix">
                            <?php $j = 1;
                            foreach (Yii::$app->params['languages'] as $key => $language): ?>
                                <?php $active = ($j == 1) ? ' active' : '' ?>
                                <div class="tab-pane<?= $active ?>" id="<?= $j ?>c">
                                    <?= $form->field($model, 'seo_keywords_' . $key, [
                                        'template' => '
                                            {label}
                                            <div class="input-group">
                                                {input}' .
                                            '<span class="btn-other-seo-title-category input-group-addon" title="Other SEO keywords"><i class="fa fa-language"></i></span>
                                            </div>
                                            {error}
                                        ',
                                    ]); ?>
                                </div>
                                <?php $j++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- /block seo keywords  -->
            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Save') : '<i class="fa fa-floppy-o"></i> ' . Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
