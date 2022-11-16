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
 * This is the model class for table "promo_status".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $img
 * @property integer $sort_position
 */
class PromoStatus extends \yii\db\ActiveRecord
{

    public $fileimg;
    //public $no_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language,], 'required'],
            [['sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 1000],
            [['fileimg'], 'file'],
            //['no_image', 'safe'],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = PromoStatus::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
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
            'name_en' => Yii::t('app', 'Name En'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'img' => Yii::t('app', 'Img'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            //'no_image' => Yii::t('app', 'Do not use an image'),
        ];
    }

    public function uploadFile () {
        $imageName = substr(uniqid('img'), 0, 12);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/promo-status/' . $imageName . '.' . $this->fileimg->extension;
        $filePath = '../../frontend/web/' . $path;
        $this->fileimg->saveAs($filePath);

        /* resize */
        // $img = imagine\Image::getImagine()
        //     ->open($filePath);
        // $size = $img->getSize();
        // $ratio = $size->getWidth()/$size->getHeight();
        // $width = 300;
        // $height = round($width/$ratio);

        // $box = new Box($width, $height);
        // $img->resize($box)->save($filePath);

        $this->img = $path;
    }

    public static function getPromoStatusName($promo_status_id)
    {
        $promo_status = PromoStatus::findOne(['id' => $promo_status_id]);
        if (empty($promo_status)) {
            return null;
        } else {
            $name = 'name_'.Yii::$app->language;
            return $promo_status->$name;    
        }
         
    }

}
