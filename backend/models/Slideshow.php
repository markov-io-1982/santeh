<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * This is the model class for table "slideshow".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $img
 * @property string $description_en
 * @property string $description_ru
 * @property string $description_ua
 * @property string $link_title_ua
 * @property string $link_title_en
 * @property string $link_title_ru
 * @property string $link_url
 * @property integer $sort_position
 * @property integer $status
 * @property string $date_create
 */
class Slideshow extends \yii\db\ActiveRecord
{
    public $fileimg;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slideshow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort_position', 'status'], 'integer'],
            [['date_create'], 'safe'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 200],
            [['img'], 'string', 'max' => 1000],
            [['description_en', 'description_ru', 'description_ua', 'link_url'], 'string', 'max' => 500],
            [['link_title_ua', 'link_title_en', 'link_title_ru'], 'string', 'max' => 100],
            [['fileimg'], 'file'], 
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = AttributeValue::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
            [['date_create'], 'filter', 'filter' => function ($value) {
                return date('Y-m-d H:i:s');
            } ],
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
            'img' => Yii::t('app', 'Image'),
            'description_en' => Yii::t('app', 'Description in English'),
            'description_ru' => Yii::t('app', 'Description in Russian'),
            'description_ua' => Yii::t('app', 'Description in Ukrainian'),
            'link_title_ua' => Yii::t('app', 'Link Title in Ukrainian'),
            'link_title_en' => Yii::t('app', 'Link Title in English'),
            'link_title_ru' => Yii::t('app', 'Link Title in Russian'),
            'link_url' => Yii::t('app', 'Link'),
            'sort_position' => Yii::t('app', 'Order number'),
            'status' => Yii::t('app', 'Status'),
            'date_create' => Yii::t('app', 'Date Create'),
            'fileimg' => Yii::t('app', 'Image'),
        ];
    }

    public function uploadFile () {
        $imageName = substr(uniqid('slide'), 0, 12);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/slideshow/' . $imageName . '.' . $this->fileimg->extension;
        $filePath = '../../frontend/web/' . $path;
        $this->fileimg->saveAs($filePath);

        /* resize */
        $img = imagine\Image::getImagine()
            ->open($filePath);
        // $size = $img->getSize();
        // $ratio = $size->getWidth()/$size->getHeight();
        $width = 1350;
        $height = 500;

        $box = new Box($width, $height);
        $img->resize($box)->save($filePath);

        $this->img = $path;
    }


}
