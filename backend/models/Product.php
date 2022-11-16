<?php

namespace backend\models;

use Yii;

use yii\web\UploadedFile;
use yii\imagine;
use yii\imagine\Image;

use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\BoxInterface;

use common\models\Configs;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $category_id
 * @property integer $sort_position
 * @property string $intro_text_en
 * @property string $intro_text_ru
 * @property string $intro_text_ua
 * @property string $price
 * @property string $price_old
 * @property integer $quantity
 * @property integer $min_order
 * @property integer $reserve
 * @property integer $promo_status_id
 * @property string $promo_date_end
 * @property integer $stock_status_id
 * @property string $img
 * @property integer $on_main
 * @property string $slug
 * @property integer $status
 * @property string $kode
 */
class Product extends \yii\db\ActiveRecord
{
    public $fileimg;
    public $date_promo_date_end;
    public $time_promo_date_end;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['category_id', 'price'], 'required'],
            [['category_id'], 'required'],
            [['name_' . Yii::$app->language], 'required'],
            [['category_id', 'sort_position', 'quantity', 'min_order', 'reserve', 'promo_status_id', 'stock_status_id', 'on_main', 'status', 'isset_product_combination'], 'integer'],
            [['price', 'price_old'], 'number'],
            [['promo_date_end', 'date_promo_date_end', 'time_promo_date_end'], 'safe'],
            [['name_en', 'name_ru', 'name_ua', 'slug'], 'string', 'max' => 255],
            [['intro_text_en', 'intro_text_ru', 'intro_text_ua', 'img'], 'string', 'max' => 1000],
            [['slug'], 'unique'],
            [['fileimg'], 'file'],
            [['kode'], 'string', 'max' => 50],
            [['date_create', 'date_update', ], 'safe'],

            ['slug', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $name = 'name_' . Yii::$app->language;
                    $value =  Slug::getSlug($this->$name, 255);
                }
                return $value;
            }],

            ['date_create', 'filter', 'filter' => function ($value) {
                if ($this->isNewRecord) {
                    $value = date('Y-m-d H:i:s');
                }
                return $value;
            }],
            ['date_update', 'filter', 'filter' => function ($value) {
                return date('Y-m-d H:i:s');
            }],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '' || $value <= 0) {
                    $max = Product::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
            ['min_order', 'filter', 'filter' => function ($value) {
                return ($value == '') ? 1 : $value;
            }],
            [['promo_status_id', 'stock_status_id', 'reserve', 'price', 'price_old', 'quantity'], 'filter', 'filter' => function ($value){
                return $value = ($value == '') ? 0 : $value;
            }],
            ['isset_product_combination', 'filter', 'filter' => function ($value) {
                return ($value == '') ? 0 : $value;
            }],
            // [['name_en', 'name_ru', 'name_ua'], 'filter', 'filter' => function ($value) {
            //     if ($value == '') {
            //         $name = 'name_' . Yii::$app->language;
            //         $value = $this->$name;
            //     }
            //     return $value;
            // }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_en' => Yii::t('app', 'Name in English'),
            'name_ru' => Yii::t('app', 'Name in Russian'),
            'name_ua' => Yii::t('app', 'Name in Ukrainian'),
            'category_id' => Yii::t('app', 'Category'),
            'sort_position' => Yii::t('app', 'Order number'),
            'intro_text_en' => Yii::t('app', 'Intro in English'),
            'intro_text_ru' => Yii::t('app', 'Intro in Russian'),
            'intro_text_ua' => Yii::t('app', 'Intro in Ukrainian'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
            'quantity' => Yii::t('app', 'Quantity'),
            'min_order' => Yii::t('app', 'Min Order'),
            'reserve' => Yii::t('app', 'Reserve'),
            'promo_status_id' => Yii::t('app', 'Promo Status'),
            'promo_date_end' => Yii::t('app', 'End date promo status'),
            'stock_status_id' => Yii::t('app', 'Stock Status'),
            'img' => Yii::t('app', 'Image'),
            'on_main' => Yii::t('app', 'On Main'),
            'slug' => Yii::t('app', 'Slug'),
            //'status' => Yii::t('app', 'Status'),
            'status' => Yii::t('app', 'Publish'),
            'fileimg' => Yii::t('app', 'Image'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_update' => Yii::t('app', 'Date Update'),
            'isset_product_combination' => Yii::t('app', 'Isset Product Combination'),
            'kode' => Yii::t('app', 'Kode'),
        ];
    }

    public function getTime() {
        $this->promo_date_end = $this->date_promo_date_end . ' ' . $this->time_promo_date_end;
        //$this->promo_date_end = date('Y-m-d') . ' ' . $this->time_promo_date_end;
    }

    public function setTime() {
        $this->date_promo_date_end = date('Y-m-d', strtotime($this->promo_date_end));
        $this->time_promo_date_end = date('H:i:s', strtotime($this->promo_date_end));
    }

    public function uploadFile() {
        $imageName = substr(uniqid('img'), 0, 12);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/products/' . $imageName . '.' . $this->fileimg->extension;
        $filePath = '../../frontend/web/' . $path;
        $this->fileimg->saveAs($filePath);

        /* resize and crop */
        $width = 600;
        $height = 640;

        $img = imagine\Image::getImagine()
            ->open($filePath);
        $size = $img->getSize();
        $ratio = $size->getWidth()/$size->getHeight();  // соотношение

        if ($ratio <= 1) {  // ratio < 1 то изображение имеет портретную ориентацию или квадрат

            $new_ratio = $size->getHeight()/$size->getWidth();      // находим новое соотношение высота к ширене

            $img->resize(new Box($width, $height * $new_ratio))     // resize
                ->save($filePath, ['jpeg_quality' => 100]);

            $img = imagine\Image::getImagine()                      // открываем заново изображение
                ->open($filePath);

            $size = $img->getSize();

            $point_y = ($size->getHeight() - $height) / 2 ;           // находим точку-начало обрезки по оси y (отступ сверху)

            $img->crop(new Point( 0, $point_y ), new Box($width, $height))
               ->save($filePath, ['jpeg_quality' => 100]);

        }
        else if ($ratio > 1) {                                      // ratio > 1 изображение имеет ландшафтную ориентацию

            $img->resize( new Box(($width*$ratio), $height) )       // resize
                ->save($filePath, ['jpeg_quality' => 100]);

            $img = imagine\Image::getImagine()                      // открываем заново изображение
                ->open($filePath);

            $size = $img->getSize();                                //  получаем новые размеры

            $point_x = ($size->getWidth() - $width) / 2 ;           // находим точку-начало обрезки по оси x (отступ слева)

            $img->crop(new Point( $point_x, 0 ), new Box($width, $height))      // обрезаем изображение (отсекаем слева и права)
               ->save($filePath, ['jpeg_quality' => 100]);
        }

        $this->img = $path;
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }


    public static function importXls($model) {
        if(!$model) return false;
        $importName = substr(uniqid('import_products_'), 0, 12);

        $file = UploadedFile::getInstance($model, 'file');
        if(!$file) return false;
        $dir = 'files/xls/';
        if(!is_dir($dir)) @mkdir($dir, 0777, TRUE);
        $fileName = $dir . $importName . '.' . $file->extension;
        $file->saveAs($fileName);

        /*
        $data = \moonland\phpexcel\Excel::import($fileName, [
                'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                //'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                //'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);
        */
        /*
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;*/

        $r = \PHPExcel_CachedObjectStorageFactory::initialize(\PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp);
        if ( ! $r ) { die('Unable to set cell cacheing'); }
        \PHPExcel_Settings::setCacheStorageMethod( $r );
        $objReader = \PHPExcel_IOFactory::createReader(\PHPExcel_IOFactory::identify($fileName));
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($fileName);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        //for ($i = 1; $i <= 10; $i++) {
        //     $heder[$i]= $objWorksheet->getCellByColumnAndRow($i, 1);
        //}

        /*
        require_once 'excel_reader2.php';
        $reader = new \Spreadsheet_Excel_Reader();
        $reader->read($fileName);
        $highestRow = count($reader->sheets[0]['cells']);
        */

        @unlink($fileName);

        $log = [];
        $count_ok = 0;
        $count_not = 0;
        $xls_kode = Configs::byCode('xls_kode');
        $xls_cost = Configs::byCode('xls_cost');
        $xls_valute = Configs::byCode('xls_valute');
        $xls_name = Configs::byCode('xls_name');

        /*
        $length = count($reader->sheets[1]['cells']);
        for ($i = 4; $i <= $length; $i++) {
            $row = $reader->sheets[1]['cells'][$i];
            print_r($row);
        }
        */

        for ($row = 2; $row <= $highestRow; ++$row) {

            $kode = trim($objWorksheet->getCellByColumnAndRow(0, $row)->getValue());
            $cost_orig = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
            $valute = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getValue());
            $name = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();

            /*
            $row_a = $reader->sheets[1]['cells'][$row];
            $kode = $row_a[0];
            $cost_orig = $row_a[3];
            $valute = $row_a[4];
            $name = $row_a[1];
            */

            if($valute=='грн') {
                $ccr = Configs::byCode('ccr');
		    } else if ($valute == 'eur') {
			     $ccr = Configs::byCode('currensy_usd_eur');
    		} else if ($valute == 'rub') {
			     $ccr = Configs::byCode('corrency_USD_RUB');
		    } else if ($valute == 'usd') {
			     $ccr = 1;
			}
            $cost = round( $cost_orig / $ccr, 2);
            /*
            $cost = $cost_orig / $ccr;
            echo $cost_orig;
            echo '</br>';
            echo $ccr;
            echo '</br>';
            echo $cost;
            die;
            */

            $product = Product::findOne([
                'kode' => $kode,
                'status' => 1,
            ]);
            if($product) {
               $product->price = $cost;
               if(!$product->save()){
                    $log[] = [
                        'kode' => $kode,
                        'cost' => $cost,
                        'valute' => $valute,
                        'cost_orig' => $cost_orig,
                        'name' => $name,
                        'row' => $row,
                        'error' => 1,
                        'errors' => $product->errors
                   ];
                   $count_not++;
               } else {
                    $log[] = [
                        'kode' => $kode,
                        'cost' => $cost,
                        'valute' => $valute,
                        'cost_orig' => $cost_orig,
                        'name' => $name,
                        'row' => $row,
                        'error' => 0,
                   ];
                   $count_ok++;
               }

            } else {
               /* Без учета комбинаций
               $log[] = [
                    'kode' => $kode,
                    'cost' => $cost,
                    'valute' => $valute,
                    'cost_orig' => $cost_orig,
                    'name' => $name,
                    'row' => $row,
                    'error' => 2,
               ];
               $count_not++;
               */

               $product_comb = ProductCombination::findOne([
                    'kode' => $kode,
                    'status' => 1,
                ]);
                if($product_comb) {
                   $product_comb->price = $cost;
                   if(!$product_comb->save()) {
                        $log[] = [
                            'kode' => $kode,
                            'cost' => $cost,
                            'valute' => $valute,
                            'cost_orig' => $cost_orig,
                            'name' => $name,
                            'row' => $row,
                            'error' => 3,
                            'errors' => $product->errors
                       ];
                       $count_not++;
                   } else {
                        $log[] = [
                            'kode' => $kode,
                            'cost' => $cost,
                            'valute' => $valute,
                            'cost_orig' => $cost_orig,
                            'name' => $name,
                            'row' => $row,
                            'error' => 0,
                       ];
                       $count_ok++;
                   }

                } else {
                   $log[] = [
                        'kode' => $kode,
                        'komb' => true,
                        'cost' => $cost,
                        'valute' => $valute,
                        'cost_orig' => $cost_orig,
                        'name' => $name,
                        'row' => $row,
                        'error' => 2,
                   ];
                   $count_not++;
                }
            }

        }

        // Перебор всех строк с данными
        /*
        foreach ($data as $key=>$row) {

            $kode = $row[$xls_kode];
            $cost_orig = $row[$xls_cost];
            $valute = $row[$xls_valute];
            $name = $row[$xls_name];

            if($valute=='грн') {
                $ccr = \common\models\Configs::byCode('ccr');
		    } else if ($valute == 'eur') {
			     $ccr = \common\models\Configs::byCode('currensy_usd_eur');
    		} else if ($valute == 'rub') {
			     $ccr = \common\models\Configs::byCode('corrency_USD_RUB');
		    } else if ($valute == 'usd') {
			     $ccr = 1;
			}
            $cost = round($cost_orig / $ccr, 2);

            $product = Product::findOne([
                'kode'=>$kode,
                'status'=>1,
            ]);
            if($product) {
               $product->price = $cost;
               if(!$product->save()){
                    $log[] = [
                        'kode' => $kode,
                        'cost' => $cost,
                        'valute' => $valute,
                        'cost_orig' => $cost_orig,
                        'name' => $name,
                        'row' => $key+2,
                        'error' => 1,
                        'errors' => $product->errors
                   ];
                   $count_not++;
               } else {
                    $log[] = [
                        'kode' => $kode,
                        'cost' => $cost,
                        'valute' => $valute,
                        'cost_orig' => $cost_orig,
                        'name' => $name,
                        'row' => $key+2,
                        'error' => 0,
                   ];
                   $count_ok++;
               }

            } else {
               $log[] = [
                    'kode' => $kode,
                    'cost' => $cost,
                    'valute' => $valute,
                    'cost_orig' => $cost_orig,
                    'name' => $name,
                    'row' => $key+2,
                    'error' => 2,
               ];
               $count_not++;
            }
        }
        */

        $status = 'ok';
        if($count_not>0) $status = 'error';

        $data = [
            'status'=>$status,
            'log'=>$log,
            //'total_row' => count($data),
            'total_row' => $highestRow-1,
            'count_ok'=>$count_ok,
            'count_not'=>$count_not,
            'xls_kode' => $xls_kode,
            'xls_cost' => $xls_cost,
            'xls_valute' => $xls_valute,
            'xls_name' => $xls_name,
        ];
        return $data;
        /*
        $data = \moonland\phpexcel\Excel::widget([
                'mode' => 'import',
                'fileName' => $fileName,
                'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);

        $data = \moonland\phpexcel\Excel::import($fileName, [
                'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
            ]);
        */
    }

}
