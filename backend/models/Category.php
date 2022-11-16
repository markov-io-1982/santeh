<?php

namespace backend\models;

use Yii;

use yii\web\UploadedFile;
use yii\imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;


/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $parent_id
 * @property integer $sort_position
 * @property string $slug
 * @property string $seo_title_en
 * @property string $seo_title_ru
 * @property string $seo_title_ua
 * @property string $seo_description_en
 * @property string $seo_description_ru
 * @property string $seo_description_ua
 * @property string $seo_keywords_en
 * @property string $seo_keywords_ru
 * @property string $seo_keywords_ua
 * @property string $date_create
 * @property string $date_update
 * @property integer $status
 */
class Category extends \yii\db\ActiveRecord
{
    // Object image file
    public $fileimg;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language, 'description_' . Yii::$app->language], 'required'],
            [['parent_id', 'sort_position', 'status'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['fileimg'], 'file'],
            [['name_en', 'name_ru', 'name_ua', 'slug', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'img'], 'string', 'max' => 255],
            [['description_en', 'description_ru', 'description_ua'], 'string', 'max' => 2000],
            [['seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua'], 'string', 'max' => 200],
            ['slug', 'unique'],
            ['slug', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $name = 'name_' . Yii::$app->language;
                    $value = Slug::getSlug($this->$name, 255);
                }
                return $value;
            }],
//            ['seo_title_' . Yii::$app->language, 'filter', 'filter' => function ($value) {
//                if ($value) {
//                    $name = 'name_' . Yii::$app->language;
//                    $value = $this->$name;
//                }
//                return $value;
//            }],
            ['date_create', 'filter', 'filter' => function ($value) {
                if ($this->isNewRecord) {
                    $value = date('Y-m-d H:i:s');
                }
                return $value;
            }],
            ['date_update', 'filter', 'filter' => function ($value) {
                if (!$this->isNewRecord) {
                    $value = date('Y-m-d H:i:s');
                } else {
                    $value = $this->date_create;
                }
                return $value;
            }],
            ['parent_id', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $value = 0;
                }
                return $value;
            }],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = Category::find()->orderBy('sort_position DESC')->one();
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
            ['parent_id', 'validateParentCategory'],

        ];
    }

    public function validateParentCategory($attribute, $params)
    {
        if ($this->$attribute != 0) { // если есть родительськая категория
            $parent_category = Category::findOne(['id' => $this->$attribute]); // получаем родительськую категорию
            if ($parent_category['parent_id'] != 0) { // если есть родитель
                $parent_parent_category = Category::findOne(['id' => $parent_category['parent_id']]);
                if ($parent_parent_category['parent_id'] != 0) {
                    $parent_parent_categorys = Category::findOne(['id' => $parent_parent_category['parent_id']]);
                    if ($parent_parent_categorys['parent_id'] != 0) { // если есть родитель
                        $parent_parent_parent_category = Category::findOne(['id' => $parent_parent_categorys['parent_id']]);
                        if ($parent_parent_parent_category['parent_id'] != 0) { // если есть родитель
                            $this->addError($attribute, 'Слишком большая вложеность');
                        }
                    }
                }
            }
        }
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
            'description_en' => Yii::t('app', 'Description in English'),
            'description_ru' => Yii::t('app', 'Description in Russian'),
            'description_ua' => Yii::t('app', 'Description in Ukrainian'),
            'parent_id' => Yii::t('app', 'Parent Category'),
            'sort_position' => Yii::t('app', 'Order number'),
            'slug' => Yii::t('app', 'Slug'),
            'img' => Yii::t('app', 'Image'),
            'seo_title_en' => Yii::t('app', 'Seo Title En'),
            'seo_title_ru' => Yii::t('app', 'Seo Title Ru'),
            'seo_title_ua' => Yii::t('app', 'Seo Title Ua'),
            'seo_description_en' => Yii::t('app', 'Seo Description En'),
            'seo_description_ru' => Yii::t('app', 'Seo Description Ru'),
            'seo_description_ua' => Yii::t('app', 'Seo Description Ua'),
            'seo_keywords_en' => Yii::t('app', 'Seo Keywords En'),
            'seo_keywords_ru' => Yii::t('app', 'Seo Keywords Ru'),
            'seo_keywords_ua' => Yii::t('app', 'Seo Keywords Ua'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_update' => Yii::t('app', 'Date Update'),
            'status' => Yii::t('app', 'Status'),
            'fileimg' => Yii::t('app', 'Image'),
        ];
    }

    public static function getCategoryName($category_id)
    {
        $category = Category::findOne(['id' => $category_id]);
        $name = 'name_' . Yii::$app->language;
        if (empty($category)) {
            return null;
        } else {
            return $category->$name;
        }

    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * The method for upload file
     * Use table category_images
     * Category model
     * Using in page create category controller
     */
    public function uploadFile() {

        $imageName = substr(uniqid('img'), 0, 12);
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/category/' . $imageName . '.' . $this->fileimg->extension;
        $filePath = '../../frontend/web/' . $path;

        if (file_exists('../../frontend/web/images/uploads/category/')) {
        	
            $this->fileimg->saveAs($filePath);

            /* resize and crop */
            /*
            $width = 360;
            $height = 200;

            $img = imagine\Image::getImagine()->open($filePath);
            
			$size = $img->getSize();
            
			$ratio = $size->getWidth() / $size->getHeight();  // Relationships side
            
			if ($ratio <= 1) {  // ratio < 1 то изображение имеет портретную ориентацию или квадрат
                $new_ratio = $size->getHeight() / $size->getWidth();      // находим новое соотношение высота к ширене
                
				// resize
				$img->resize(new Box($width, $height * $new_ratio))->save($filePath, ['jpeg_quality' => 100]);

                // открываем заново изображение
				$img = imagine\Image::getImagine()->open($filePath);

                $size = $img->getSize();

                $point_y = ($size->getHeight() - $height) / 2;           // находим точку-начало обрезки по оси y (отступ сверху)

                $img->crop(new Point(0, $point_y), new Box($width, $height))->save($filePath, ['jpeg_quality' => 100]);

            } else if ($ratio > 1) {    // ratio > 1 изображение имеет ландшафтную ориентацию

                // resize
				$img->resize(new Box(($width * $ratio), $height))->save($filePath, ['jpeg_quality' => 100]);

                // открываем заново изображение
				$img = imagine\Image::getImagine()->open($filePath);

                $size = $img->getSize();                                //  получаем новые размеры

                $point_x = ($size->getWidth() - $width) / 2;           // находим точку-начало обрезки по оси x (отступ слева)

                // обрезаем изображение (отсекаем слева и права)
				$img->crop(new Point($point_x, 0), new Box($width, $height))->save($filePath, ['jpeg_quality' => 100]);
            }
            */

            $this->img = $path;

        } else {

            Yii::$app->session->setFlash ( 'warning', Yii::t('app', 'Sorry, but not exist directory for save images.') );

        }

        return true;

    }

    /**
     * Build tree categories
     * @return array
     */
    public static function buildTree()
    {
        $category = self::find()->all();
        $tree = [];
        foreach ($category as $id => &$node) {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $category[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }
}
