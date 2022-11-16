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
 * This is the model class for table "attribute_value".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $slug
 * @property integer $attribute_id
 * @property string $img
 * @property integer $sort_position
 */
class AttributeValue extends \yii\db\ActiveRecord
{

    public $fileimg;
    public $no_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language, 'attribute_id'], 'required'],
            [['attribute_id', 'sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua', 'slug'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 1000],
            [['fileimg'], 'file'],      
            [['no_image'], 'safe'],      
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
            ['slug', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $name = 'name_' . Yii::$app->language;
                    $value =  Slug::getSlug($this->$name, 255);
                }
                return $value;
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
            'attribute_id' => Yii::t('app', 'Attribute'),
            'img' => Yii::t('app', 'Image'),
            'sort_position' => Yii::t('app', 'Order number'),
            'slug' => Yii::t('app', 'Slug'),
            'fileimg' => Yii::t('app', 'Image'),
            'no_image' => Yii::t('app', 'Do not use an image'),
        ];
    }

    public function uploadFile () {
        $imageName = substr(uniqid('img'), 0, 12);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/attribute/' . $imageName . '.' . $this->fileimg->extension;
        $filePath = '../../frontend/web/' . $path;
        $this->fileimg->saveAs($filePath);

        /* resize */
        $img = imagine\Image::getImagine()
            ->open($filePath);
        $size = $img->getSize();
        $ratio = $size->getWidth()/$size->getHeight();
        $width = 160;
        $height = round($width/$ratio);

        $box = new Box($width, $height);
        $img->resize($box)->save($filePath);

        $this->img = $path;
    }

    public function getAttributeList()
    {
        return $this->hasOne(AttributeList::className(), ['id' => 'attribute_id']);
    }  

}
