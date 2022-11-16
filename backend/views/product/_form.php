<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

use backend\models\Category;
use backend\models\PromoStatus;
use backend\models\StockStatus;
use backend\models\RelationsProductProduct;
use backend\models\ProductImages;
use backend\models\RelationsProductAtribute;
use backend\models\ProductCombination;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#genelar_information" data-toggle="tab"><?= Yii::t('app', 'General information') ?></a></li>
            <?php if(!$model->isNewRecord): ?>
            <li><a href="#description" data-toggle="tab"><?= Yii::t('app', 'Description') ?></a></li>
            <li><a href="#attributes" data-toggle="tab"><?= Yii::t('app', 'Attributes') ?></a></li>
            <li><a href="#combinations" data-toggle="tab"><?= Yii::t('app', 'Product combinations') ?></a></li>
            <li><a href="#statistics" data-toggle="tab"><?= Yii::t('app', 'Statistics') ?></a></li>
            <li><a href="#seo" data-toggle="tab"><?= Yii::t('app', 'SEO') ?></a></li>
            <li><a href="#imgs" data-toggle="tab"><?= Yii::t('app', 'Images') ?></a></li>
            <li><a href="#products" data-toggle="tab"><?= Yii::t('app', 'Related products') ?></a></li>
            <?php endif; ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="genelar_information">

                <div class="row">
                    <div class="col-md-6">

                        <?= $form->field($model, 'kode'); ?>

                        <?= $form->field($model, 'name_' . Yii::$app->language, [
                            'template' => '
                                {label}
                                <div class="input-group">
                                    {input}'.
                                    '<span class="input-group-addon btn-other-name" title="'. Yii::t('app', 'Name in other languages') .'"><i class="fa fa-language"></i></span>
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

                        <hr/>

                        <?= $form->field($model, 'category_id')->dropDownList(
                            ArrayHelper::map(Category::find()->all(), 'id', 'name_' . Yii::$app->language ),
                            ['prompt'=> '-- ' . Yii::t('app', 'Select a category') . ' --']
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
                                    ',
                                ]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'price', [
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
                            <div class="col-md-6">
                                <?= $form->field($model, 'price_old', [
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

                        <div class="row">
                            <div class="col-md-6">

                                <?php if ($model->isset_product_combination == 0): ?>

                                    <?= $form->field($model, 'quantity', [
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

                                <?php endif; ?>

                                <?php if ($model->isset_product_combination == 1): ?>
                                    <?= $form->field($model, 'quantity')->textInput(['readonly' => 'readonly']) ?>
                                <?php endif; ?>


                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'min_order', [
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

                        <?= $form->field($model, 'promo_status_id')->dropDownList(
                            ArrayHelper::map(PromoStatus::find()->all(), 'id', 'name_' . Yii::$app->language ),
                            ['prompt'=> '-- ' . Yii::t('app', 'Select the promo status') . ' --']
                        ) ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'date_promo_date_end')->widget(DatePicker::classname(), [
                                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                    'value' => date('d-M-Y', strtotime('+2 days')),
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'time_promo_date_end')->widget(TimePicker::classname(), [
                                    'pluginOptions' => [
                                        'showSeconds' => true,
                                        'showMeridian' => false,
                                        'minuteStep' => 1,
                                        'secondStep' => 5,
                                    ]
                                ]) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'stock_status_id')->dropDownList(
                            ArrayHelper::map(StockStatus::find()->all(), 'id', 'name_' . Yii::$app->language ),
                            ['prompt'=> '-- ' . Yii::t('app', 'Select stock status') . ' --']
                        ) ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'status')->checkbox() ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'on_main')->checkbox() ?>
                            </div>
                        </div>

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

                        <?php if (!$model->isNewRecord): ?>

                            <div class="box box-solid box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= Yii::t('app', 'Old image') ?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if ($model->img == '') {
                                        echo Yii::t('app', 'No image');
                                    } else {
                                        echo Html::img('../../frontend/web/' . $model->img, ['style' => 'width:100%;'] );
                                    }
                                    ?>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        <?php endif; ?>

                    </div>
                </div>

            </div>
            <!-- /.tab-pane -->

            <?php if(!$model->isNewRecord): ?>

            <div class="tab-pane" id="description">

                <!-- product_detail intro-text START -->

<!--                 <div class="row">
                	<div class="col-md-11"> -->
						<?php // $form->field($model, 'intro_text_' . Yii::$app->language)->widget(CKEditor::className(), [
							//	'options' => ['rows' => 3],
							//	'preset' => 'basic'
							//]) ?>
<!--
						<div class="other-intro" style="display:none;"> -->

								<?php // foreach (Yii::$app->params['languages'] as $key => $language): ?>

                                    <?php // if ($key == Yii::$app->language) {
                                        // continue;
                                   // } ?>

									<?php // $form->field($model, 'intro_text_' . $key)->widget(CKEditor::className(), [
										//	'options' => ['rows' => 3],
										//	'preset' => 'basic'
										// ]) ?>

                                <?php // endforeach; ?>


<!-- 						</div>
                	</div>
                	<div class="col-md-1">
                		<div class="btn-other-intro">
							<i class="fa fa-language fa-3x"></i>
							<span>Intro</span>
                		</div>

                	</div>
                </div> -->

                <!-- product_detail intro-text END -->

                <hr/>

                <!-- product_detail description START -->

                <div class="row">
                	<div class="col-md-11">

						<?= $form->field($product_detail, 'description_' . Yii::$app->language)->widget(CKEditor::className(), [
								'options' => ['rows' => 6],
								'preset' => 'full'
							]) ?>

						<div class="other-description" style="display:none;">

							<?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

								<?php if ($key == Yii::$app->language) {
									continue;
								} ?>

								<?= $form->field($product_detail, 'description_' . $key)->widget(CKEditor::className(), [
										'options' => ['rows' => 3],
										'preset' => 'full'
									]) ?>

							<?php endforeach; ?>

						</div>

                	</div>

                	<div class="col-md-1">
                		<div class="btn-other-description" title="<?= Yii::t('app', 'Description in other languages') ?>">
							<i class="fa fa-language fa-3x"></i>
							<span></span>
                		</div>
                	</div>
                </div>

                <!-- product_detail description END -->

               	<hr/>

                <!-- product_detail complectation START -->



                <div class="row">
                	<div class="col-md-11">

						<?= $form->field($product_detail, 'complectation_' . Yii::$app->language)->widget(CKEditor::className(), [
								'options' => ['rows' => 6],
								'preset' => 'full'
							]) ?>

						<div class="other-complectation" style="display:none;">

							<?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

								<?php if ($key == Yii::$app->language) {
									continue;
								} ?>

								<?= $form->field($product_detail, 'complectation_' . $key)->widget(CKEditor::className(), [
										'options' => ['rows' => 3],
										'preset' => 'full'
									]) ?>

							<?php endforeach; ?>

						</div>

                	</div>

                	<div class="col-md-1">
                		<div class="btn-other-complectation" title="<?= Yii::t('app', 'Complectation in other languages') ?>">
							<i class="fa fa-language fa-3x"></i>
							<span></span>
                		</div>
                	</div>
                </div>

                <script>
//					CKEDITOR.replace('product-intro_text_en', { width: '100%', height: '1000px' });
//					CKEDITOR.replace('product-intro_text_ru', { width: '100%', height: '1000px' });
//                    CKEDITOR.replace('product-intro_text_ua', { width: '100%', height: '1000px' });
//					CKEDITOR.replace('productdetail-description_en', { width: '100%', height: '1000px' });
//					CKEDITOR.replace('productdetail-description_ru', { width: '100%', height: '1000px' });
//                    CKEDITOR.replace('productdetail-description_ua', { width: '100%', height: '1000px' });
//					CKEDITOR.replace('productdetail-complectation_en', { width: '100%', height: '1000px' });
//					CKEDITOR.replace('productdetail-complectation_ru', { width: '100%', height: '1000px' });
//                    CKEDITOR.replace('productdetail-complectation_ua', { width: '100%', height: '1000px' });
                </script>

                <!-- product_detail complectation END -->

            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="attributes">


                <div class="row">
                    <div class="col-md-12">

                        <?php Pjax::begin([
                            'id' => 'realtions_attribute'
                        ]); ?>

                        <?php $attributes = RelationsProductAtribute::getReationsAtribute($model->id); ?>

                        <div class="box">
                            <div class="box-header">
                              <h3 class="box-title"><?= Yii::t('app', 'Attributes') ?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                              <table class="table table-condensed rel-attributes-table">
                                <tbody><tr>
                                  <th style="width: 5%">#</th>
                                  <th style="width: 30%"><?= Yii::t('app', 'Attribute') ?></th>
                                  <th style="width: 30%"><?= Yii::t('app', 'Value') ?></th>
                                  <th style="width: 20%"><?= Yii::t('app', 'Image') ?></th>
                                  <th style="width: 5%"><?= Yii::t('app', 'Sort') ?></th>
                                  <th style="width: 10%"></th>
                                </tr>

                                <?php $i=1; foreach($attributes as $attr):  ?>

                                <tr>
                                  <td><?= $i++ ?>.</td>
                                  <td><?= $attr['attribute'] ?></td>
                                  <td><?= $attr['value'] ?></td>
                                  <td><?= ($attr['img'] == '') ? null : Html::img('../../frontend/web/'. $attr['img'], ['class' => 'img-responsive', 'style' => 'width: 36px;']) ?></td>
                                  <td><?= $attr['sort'] ?></td>
                                  <td>
                                    <?= Html::tag('span', '<i class="fa fa-trash"></i>', [
                                        'value' => Url::to(['/relations-product-atribute/delete', 'id' => $attr['id']]),
                                        'class' => 'btn btn-danger delete-rel-attribute',
                                        'title' => Yii::t('app', 'Delete')
                                    ]); ?>
                                    <span class="badge bg-red"></span>
                                  </td>
                                </tr>

                                <?php endforeach;  ?>

                              </tbody></table>
                            </div>
                            <!-- /.box-body -->
                        </div>

                        <?php Pjax::end(); ?>

                    </div>
                </div><!-- /-row -->

                <?= Html::button('<i class="fa fa-plus"></i> ' . Yii::t('app', 'Add attribute'), [
                                    'value' => Url::to(['/relations-product-atribute/create', 'product_id' => $model->id ]),
                                    'class' => 'btn btn-succeess',
                                    'id' => 'modalButtonAttribute'
                                ]) ?>


                <?php
                    Modal::begin([
                            'header' => '<h4>' . Yii::t('app', 'Add a attribute') . '</h4>',
                            'id' => 'modal_attribute',
                            'size' => 'modal-lg',
                        ]);

                    echo "<div id='modalAttrMessage'></div><div id='modalContentAttribute'></div>";

                    Modal::end();
                ?>

            </div><!-- /.tab-pane -->

            <div class="tab-pane" id="combinations">

                <?= $form->field($model, 'isset_product_combination')->checkbox() ?>

                <div class="after-isset-product-combination" style="<?= ($model->isset_product_combination == 1) ? 'display:block;' : 'display:none;' ?>">

					<div class="row">
						<div class="col-md-12">

							<?php Pjax::begin([
								'id' => 'product_combinations'
							]); ?>

							<?php $product_combinations = ProductCombination::getCombination($model->id); ?>

							<div class="box">
								<div class="box-header">
								  <h3 class="box-title"><?= Yii::t('app', 'Product Combination') ?></h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body no-padding">
								  <table class="table table-condensed product-combination">
									<tbody><tr>
									  <th style="width: 5%">#</th>
									  <th style="width: 20%"><?= Yii::t('app', 'Attribute') ?></th>
									  <th style="width: 20%"><?= Yii::t('app', 'Value') ?></th>
									  <th style="width: 10%"><?= Yii::t('app', 'Image') ?></th>
									  <th style="width: 5%"><?= Yii::t('app', 'Status') ?></th>
									  <th style="width: 5%"><?= Yii::t('app', 'Quantity') ?></th>

                                      <th style="width: 5%"><?= Yii::t('app', 'Kode') ?></th>
                                      <th style="width: 5%"><?= Yii::t('app', 'Price') ?></th>
                                      <th style="width: 5%"><?= Yii::t('app', 'Price Old') ?></th>

									  <th style="width: 5%"><?= Yii::t('app', 'Sort') ?></th>
									  <th style="width: 5%"><?= Yii::t('app', 'Default') ?></th>
									  <th style="width: 10%"></th>
									</tr>

									<?php $i=1; foreach($product_combinations as $combination):  ?>

									<tr>
									  <td><?= $i++ ?>.</td>
									  <td><?= $combination['attribute'] ?></td>
									  <td>
                                        <?= $combination['attribute_value'] ?>
                                        <?= ($combination['attribute_value_img'] != '') ? Html::img('/' . $combination['attribute_value_img'], ['style' => 'height: 36px;']) : '' ?>
                                      </td>
									  <td>
                                        <?= ($combination['img'] != '') ? Html::img('/' . $combination['img'], ['style' => 'height: 40px;'] ) : null  ?>

                                      </td>
									  <td><?= $combination['status'] ?></td>
									  <td><?= $combination['quantity'] ?></td>

                                      <td><?= $combination['kode'] ?></td>
                                      <td><?= $combination['price'] ?></td>
                                      <td><?= $combination['price_old'] ?></td>

									  <td><?= $combination['sort_position'] ?></td>
									  <td><?= $combination['default_check'] ?></td>
									  <td>
                                        <?= Html::tag('span', '<i class="fa fa-edit"></i>', [
                                            'value' => Url::to(['/product-combination/update', 'id' => $combination['id']]),
                                            'class' => 'btn btn-info update-product-combination modalButtonCombination',
                                            'title' => Yii::t('app', 'Edit')
                                        ]); ?>
										<?= Html::tag('span', '<i class="fa fa-trash"></i>', [
											'value' => Url::to(['/product-combination/delete', 'id' => $combination['id']]),
											'class' => 'btn btn-danger delete-product-combination',
                                            'title' => Yii::t('app', 'Delete')
										]); ?>
										<span class="badge bg-red"></span>
									  </td>
									</tr>

									<?php endforeach;  ?>

								  </tbody></table>
								</div>
								<!-- /.box-body -->
							</div>

							<?php Pjax::end(); ?>

						</div>
					</div><!-- /-row -->

					<?= Html::button('<i class="fa fa-plus"></i> '. Yii::t('app', 'Add product combination'), [
										'value' => Url::to(['/product-combination/create', 'product_id' => $model->id ]),
										'class' => 'btn btn-succeess modalButtonCombination',
										//'id' => 'modalButtonCombination'
									]) ?>


					<?php
						Modal::begin([
								'header' => '<h4>' . Yii::t('app', 'Add a product combination') . '</h4>',
								'id' => 'modal_combination',
								'size' => 'modal-lg',
							]);

						echo "<div id='modalCombinationMessage'></div><div id='modalContentCombination'></div>";

						Modal::end();
					?>

                </div> <!-- /.after-isset-product-combination -->



            </div><!-- /.tab-pane -->

            <div class="tab-pane" id="statistics">
                <?= $form->field($model, 'reserve')->textInput(['readonly' => 'readonly']) ?>

                <?= $form->field($product_detail, 'buy')->textInput(['readonly' => 'readonly']) ?>

                <?= $form->field($product_detail, 'count_views')->textInput(['readonly' => 'readonly']) ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="seo">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

				<?= $form->field($product_detail, 'seo_title_' . Yii::$app->language, [
					'template' => '
						{label}
						<div class="input-group">
							{input}'.
							'<span class="input-group-addon btn-other-seo-title" title="Other SEO Title"><i class="fa fa-language"></i></span>
						</div>
						{error}
					',
				]); ?>

				<div class="row other-seo-title" style="display:none;">
					<div class="col-md-12">
						<?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

							<?php if ($key == Yii::$app->language) {
								continue;
							} ?>

							<?= $form->field($product_detail, 'seo_title_' . $key)->textInput(['maxlength' => true]) ?>

						<?php endforeach; ?>
					</div>
				</div>

               	<hr/>

				<?= $form->field($product_detail, 'seo_description_' . Yii::$app->language, [
					'template' => '
						{label}
						<div class="input-group">
							{input}'.
							'<span class="input-group-addon btn-other-seo-description" title="Other SEO Description"><i class="fa fa-language"></i></span>
						</div>
						{error}
					',
				]); ?>

				<div class="row other-seo-description" style="display:none;">
					<div class="col-md-12">
						<?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

							<?php if ($key == Yii::$app->language) {
								continue;
							} ?>

							<?= $form->field($product_detail, 'seo_description_' . $key)->textInput(['maxlength' => true]) ?>

						<?php endforeach; ?>
					</div>
				</div>

               	<hr/>

				<?= $form->field($product_detail, 'seo_keywords_' . Yii::$app->language, [
					'template' => '
						{label}
						<div class="input-group">
							{input}'.
							'<span class="input-group-addon btn-other-seo-keywords" title="Other SEO Keywords"><i class="fa fa-language"></i></span>
						</div>
						{error}
					',
				]); ?>

				<div class="row other-seo-keywords" style="display:none;">
					<div class="col-md-12">
						<?php foreach (Yii::$app->params['languages'] as $key => $language): ?>

							<?php if ($key == Yii::$app->language) {
								continue;
							} ?>

							<?= $form->field($product_detail, 'seo_keywords_' . $key)->textInput(['maxlength' => true]) ?>

						<?php endforeach; ?>
					</div>
				</div>

               	<hr/>

                <?= $form->field($product_detail, 'seo_canonical_url')->textInput(['maxlength' => true]) ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="imgs">

                <div class="row">
                    <div class="col-md-12">

                        <?php Pjax::begin([
                            'id' => 'realtions_images'
                        ]); ?>

                        <?php $images = ProductImages::getImages($model->id); ?>

                        <div class="box">
                            <div class="box-header">
                              <h3 class="box-title"><?= Yii::t('app', 'Images') ?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                              <table class="table table-condensed rel-products-table">
                                <tbody><tr>
                                  <th style="width: 10%">#</th>
                                  <th style="width: 40px"><?= Yii::t('app', 'Name') ?></th>
                                  <th style="width: 40px"><?= Yii::t('app', 'Image') ?></th>
                                  <th style="width: 10%"></th>
                                </tr>

                                <?php $i=1; foreach($images as $img):  ?>
                                <?php $name_img = 'name_'.Yii::$app->language; ?>
                                <tr>
                                  <td><?= $i++ ?>.</td>
                                  <td><?= $img->$name_img ?></td>
                                  <td><?= Html::img('../../' . $img->url, ['class' => 'img-responsive', 'style' => 'width: 200px;']) ?></td>
                                  <td>
                                    <?= Html::tag('span', '<i class="fa fa-trash"></i>', [
                                        'value' => Url::to(['/product-images/delete', 'id' => $img->id]),
                                        'class' => 'btn btn-danger delete-images-product',
                                        //'id' => '',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                        ]
                                    ]); ?>
                                    <span class="badge bg-red"></span>
                                  </td>
                                </tr>

                                <?php endforeach;  ?>

                              </tbody></table>
                            </div>
                            <!-- /.box-body -->
                        </div>

                        <?php Pjax::end(); ?>

                    </div>
                </div><!-- /-row -->

                <?= Html::button('<i class="fa fa-plus"></i>' . Yii::t('app', 'Create Image'), ['value' => Url::to(['/product-images/create', 'product_id' => $model->id ]), 'class' => 'btn btn-succeess', 'id' => 'modalButton']) ?>


                <?php
                    Modal::begin([
                            'header' => '<h4>' . Yii::t('app', 'Images') . '</h4>',
                            'id' => 'modal',
                            'size' => 'modal-lg',
                        ]);

                    echo "<div id='modalImgMessage'></div><div id='modalContent'></div>";

                    Modal::end();
                ?>

            </div>

            <div class="tab-pane" id="products">

                <div class="row">
                    <div class="col-md-12">

                        <?php Pjax::begin([
                            'id' => 'realtions_product'
                        ]); ?>

                        <?php $rel = RelationsProductProduct::getReationsProduct($model->id); ?>

                        <div class="box">
                            <div class="box-header">
                              <h3 class="box-title"><?= Yii::t('app', 'Related products') ?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                              <table class="table table-condensed rel-products-table">
                                <tbody><tr>
                                  <th style="width: 10px">#</th>
                                  <th><?= Yii::t('app', 'Name') ?></th>
                                  <th style="width: 40px"></th>
                                </tr>

                                <?php $i=1; foreach($rel as $id => $name):  ?>

                                <tr>
                                  <td><?= $i++ ?>.</td>
                                  <td><?= $name ?></td>
                                  <td>
                                    <?= Html::tag('span', '<i class="fa fa-trash"></i>', [
                                        'value' => Url::to(['/relations-product-product/delete', 'id' => $id]),
                                        'class' => 'btn btn-danger delete-rel-product',
                                        //'id' => '',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                        ]
                                    ]); ?>
                                    <span class="badge bg-red"></span>
                                  </td>
                                </tr>

                                <?php endforeach;  ?>

                              </tbody></table>
                            </div>
                            <!-- /.box-body -->
                        </div>

                        <?php Pjax::end(); ?>

                    </div>
                </div><!-- /-row -->

                <?= Html::button('<i class="fa fa-plus"></i>' . Yii::t('app', 'Add product'), [
                                    'value' => Url::to(['/relations-product-product/create', 'product_id' => $model->id ]),
                                    'class' => 'btn btn-succeess',
                                    'id' => 'modalButtonProduct'
                                ]) ?>


                <?php
                    Modal::begin([
                            'header' => '<h4>' . Yii::t('app', 'Add a related product') . '</h4>',
                            'id' => 'modal_product',
                            'size' => 'modal-lg',
                        ]);

                    echo "<div id='modalMessage'></div><div id='modalContentProduct'></div>";

                    Modal::end();
                ?>

            </div>

            <?php endif; ?>

        </div>
        <!-- /.tab-content -->

    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save and Next') : '<i class="fa fa-floppy-o"></i> '.Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
