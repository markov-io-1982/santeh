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
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $slug
 * @property integer $status
 * @property string $img
 * @property string $page_body_en
 * @property string $page_body_ru
 * @property string $page_body_ua
 * @property string $seo_title_en
 * @property string $seo_title_ru
 * @property string $seo_title_ua
 * @property string $seo_description_en
 * @property string $seo_description_ru
 * @property string $seo_description_ua
 * @property string $seo_keywords_en
 * @property string $seo_keywords_ru
 * @property string $seo_keywords_ua
 * @property string $canonical_url
 * @property string $date_create
 * @property string $date_update
 */
class Page extends \yii\db\ActiveRecord
{
    public $fileimg;
    public $no_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language], 'required'],
            [['page_body_' . Yii::$app->language], 'required'],
            [['status'], 'integer'],
            [['page_body_en', 'page_body_ru', 'page_body_ua'], 'string'],
            [['date_create', 'date_update', 'no_image'], 'safe'],
            [['name_en', 'name_ru', 'name_ua', 'slug', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua', 'canonical_url'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 2000],
            [['slug'], 'unique'],
            [['fileimg'], 'file'],
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
            [['seo_title_' . Yii::$app->language], 'filter', 'filter' => function ($value) {
                $name = 'name_' . Yii::$app->language;
                return ($value == '') ? $this->$name : $value;
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
            'slug' => Yii::t('app', 'Slug'),
            'status' => Yii::t('app', 'Status'),
            'img' => Yii::t('app', 'Img'),
            'page_body_en' => Yii::t('app', 'Page Body En'),
            'page_body_ru' => Yii::t('app', 'Page Body Ru'),
            'page_body_ua' => Yii::t('app', 'Page Body Ua'),
            'seo_title_en' => Yii::t('app', 'Seo Title En'),
            'seo_title_ru' => Yii::t('app', 'Seo Title Ru'),
            'seo_title_ua' => Yii::t('app', 'Seo Title Ua'),
            'seo_description_en' => Yii::t('app', 'Seo Description En'),
            'seo_description_ru' => Yii::t('app', 'Seo Description Ru'),
            'seo_description_ua' => Yii::t('app', 'Seo Description Ua'),
            'seo_keywords_en' => Yii::t('app', 'Seo Keywords En'),
            'seo_keywords_ru' => Yii::t('app', 'Seo Keywords Ru'),
            'seo_keywords_ua' => Yii::t('app', 'Seo Keywords Ua'),
            'canonical_url' => Yii::t('app', 'Canonical Url'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_update' => Yii::t('app', 'Date Update'),
            'no_image' => Yii::t('app', 'Do not use an image'),
        ];
    }

    public function uploadFile () {
        $imageName = substr(uniqid('slug'), 0, 5);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/page/' . $imageName . '.' . $this->fileimg->extension;
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

}
