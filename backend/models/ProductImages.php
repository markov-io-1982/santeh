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

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $url
 * @property integer $product_id
 * @property integer $sort_position
 */
class ProductImages extends \yii\db\ActiveRecord
{

    public $fileimg;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language], 'required'],
            //[['fileimg'], 'required'],
            [['product_id', 'sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 1000],
            [['fileimg'], 'file'],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = ProductImages::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
            [['name_en', 'name_ru', 'name_ua'], 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $name = 'name_' . Yii::$app->language;
                    $value = $this->$name;
                }
                return $value;
            }]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_en' => Yii::t('app', 'Name En'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'url' => Yii::t('app', 'Url'),
            'product_id' => Yii::t('app', 'Product'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'fileimg' => Yii::t('app', 'Image'),
        ];
    }

    public function uploadFile () {
        $imageName = substr(uniqid('img'), 0, 12);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/products/gallery/' . $imageName . '.' . $this->fileimg->extension;
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

        $this->url = $path;
    }

    // получаем изображения конкретного товара
    public static function getImages($id) {
        $name = 'name_' . Yii::$app->language;
        $images = ProductImages::find()
            ->select(['id', $name, 'url', 'sort_position'])
            ->where(['product_id' => $id])
            //->sortBy('sort_position')
            ->all();

        return $images;
    }

}
