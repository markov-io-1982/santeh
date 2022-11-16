<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\ImportXls */
/* @var $result mixed */

$this->title = 'Импорт xls';

if(isset($result)) {
    if($result===false) {
        echo 'Ошибка загрузки файла';
    }

    echo 'Всего строк с данными в файле: ' . $result['total_row'];
    echo '<br/>Импортировано строк: ' . $result['count_ok'];
    echo '<br/>Не импортировано строк: ' . $result['count_not'] . '<br/>';

    if(count($result['log'])>0) {
        ?>
        <table>
            <tr>
                <th style="width: 70px;">Строка</th>
                <th style="width: 150px;">Код продукта <br/>(<?= $result['xls_kode']?>)</th>
                <th style="width: 150px;">Наименование продукта <br/>(<?= $result['xls_name']?>)</th>
                <th style="width: 100px;">Цена (с xls)<br/>(<?= $result['xls_cost']?>)</th>
                <th style="width: 100px;">Валюта <br/>(<?= $result['xls_valute']?>)</th>
                <th style="width: 100px;">Цена, usd</th>
                <th>Статус</th>
            </tr>
            <?php
            foreach ($result['log'] as $row):

                if($row['error']==0) {
                    $error_str = 'OK';
                    if($row['komb']) $error_str .= ' (в комб.)';
                    $style = ' style="color:green;"';
                }
                if($row['error']==1 || $row['error']==3) {
                    $error_str = 'Ошибка записи: ';
                    foreach ($row['errors'] as $error) {
                        $error_str .= $error[0];
                    }
                    $style = ' style="color:red;"';
                }
                if($row['error']==2) {
                    $error_str = 'Не найден на сайте';
                    $style = ' style="color:red;"';
                }
            ?>
                <tr>
                    <td><?= $row['row']?></td>
                    <td><?= $row['kode']?></td>
                    <td><?= $row['name']?></td>
                    <td><?= $row['cost_orig']?></td>
                    <td><?= $row['valute']?></td>
                    <td><?= $row['cost']?></td>
                    <td <?= $style?>><?= $error_str?></td>
                </tr>
            <?php
            endforeach;
            ?>
        </table>
        <hr />
        <?php
    }
}
?>
<div class="product-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        //'showPreview' => false,
                        'removeFromPreviewOnError' => true,

                        'allowedFileExtensions' => ['xls', 'xlsx'],
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="fa fa-file-excel-o"></i> ',
                        //'browseLabel' =>  Yii::t('app', 'Select xls') .'...'
                    ],
                    'options' => ['accept' => '.xls,.xlsx']
                ])
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>