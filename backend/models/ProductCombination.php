<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

use backend\models\AttributeList;
use backend\models\AttributeValue;


/**
 * This is the model class for table "product_combination".
 *
 * @property integer $id
 * @property string $img
 * @property integer $quantity
 * @property integer $reserve
 * @property string $date_create
 * @property integer $status
 * @property integer $parent_id
 * @property integer $sort_position
 * @property integer $attribute_id
 * @property integer $attribute_value_id
 * @property integer $buy
 * @property number $price
 * @property number $price_old
 * @property string $kode
 */
class ProductCombination extends \yii\db\ActiveRecord
{

    public $fileimg;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_combination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'attribute_id', 'attribute_value_id', 'price'], 'required'],
            [['quantity', 'reserve', 'status', 'parent_id', 'sort_position', 'attribute_id', 'attribute_value_id', 'buy'], 'integer'],
            [['date_create', 'default_check'], 'safe'],
            [['price', 'price_old'], 'number'],
            [['kode'], 'string', 'max' => 50],
            [['img'], 'string', 'max' => 1000],
			[['fileimg'], 'file'],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = ProductCombination::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
            [['price_old'], 'filter', 'filter' => function ($value){
                return $value = ($value == '') ? 0 : $value;
            }],
            ['date_create', 'filter', 'filter' => function ($value) {
                if ($this->isNewRecord) {
                    $value = date('Y-m-d H:i:s');
                }
                return $value;
            }],
            // ['default_check', 'filter', 'filter' => function ($value) {
            //     return ($value = '') ? 0 : $value;
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
            'img' => Yii::t('app', 'Img'),
            'quantity' => Yii::t('app', 'Quantity'),
            'reserve' => Yii::t('app', 'Reserve'),
            'date_create' => Yii::t('app', 'Date Create'),
            'status' => Yii::t('app', 'Status'),
            'parent_id' => Yii::t('app', 'Parent'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'attribute_id' => Yii::t('app', 'Attribute'),
            'attribute_value_id' => Yii::t('app', 'Attribute Value'),
            'buy' => Yii::t('app', 'Buy'),
            'default_check' => Yii::t('app', 'Default'),
			'fileimg' => Yii::t('app', 'Image'),
            'kode' => Yii::t('app', 'Kode'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
        ];
    }

    public function uploadFile() {
        //$imageName = substr(uniqid('img'), 0, 12);
		$imageName = $this->parent_id . '-' . date('Y-m-d-H-i-s');
        $this->fileimg = UploadedFile::getInstance($this, 'fileimg');
        $path = 'images/uploads/products/combinations/' . $imageName . '.' . $this->fileimg->extension;
        $filePath = '../../frontend/web/' . $path;
        $this->fileimg->saveAs($filePath);

        /* resize */
        // $img = imagine\Image::getImagine()->open($filePath);
        // $size = $img->getSize();
        // $ratio = $size->getWidth()/$size->getHeight();
        // $width = 300;
        // $height = round($width/$ratio);
        // $box = new Box($width, $height);
        // $img->resize($box)->save($filePath);

        $this->img = $path;
    }


    /** получаем все комбинации текущого товара в виде массива (с атрибутами) */
    public static function getCombination($product_id) {

        $product_combination = ProductCombination::find()->where(['parent_id' => $product_id])->all(); // выбираем комбинации текущего товара
        $current_attribute = [];
        $current_attribute_value = [];

        foreach ($product_combination as $item_product_comb) {
            $current_attribute[] = $item_product_comb['attribute_id'];                      // отбираем только используемые ID атрибутов
            $current_attribute_value[] = $item_product_comb['attribute_value_id'];    // отбираем только используемые ID значения атрибутов
        }

        $attribute = AttributeList::find()              // отбираем только используемые атрибуты
            ->select(['id', 'name_'.Yii::$app->language])
            ->where(['id' => $current_attribute])
            ->all();
        $attribute_arr = [];
        foreach ($attribute as $attr) {                 // строи массив ID => name атрибутов
            $name = 'name_'.Yii::$app->language;
            $attribute_arr[$attr->id] = $attr->$name;
        }

        $attribute_value = AttributeValue::find()       // отбираем только используемые значения атрибутов
            ->select(['id', 'img', 'name_'.Yii::$app->language])
            ->where(['id' => $current_attribute_value])
            ->all();

        $attribute_value_arr = [];
        $attribute_value_img_arr = [];
        foreach ($attribute_value as $attr_val) {                 // строи массив ID => name значения атрибутов
            $name = 'name_'.Yii::$app->language;
            $attribute_value_arr[$attr_val->id] = $attr_val->$name;
            $attribute_value_img_arr[$attr_val->id] = $attr_val->img;
        }

        $out = [];
        foreach ($product_combination as $item) {
            $new_item = [];
            $new_item['id'] = $item['id'];
            $new_item['img'] = $item['img'];
            $new_item['quantity'] = $item['quantity'];
            $new_item['status'] = $item['status'];
            $new_item['kode'] = $item['kode'];
            $new_item['price'] = $item['price'];
            $new_item['price_old'] = $item['price_old'];

            $new_item['sort_position'] = $item['sort_position'];
            $new_item['default_check'] = $item['default_check'];
            $new_item['attribute'] = $attribute_arr[$item['attribute_id']];
            $new_item['attribute_value'] = $attribute_value_arr[$item['attribute_value_id']];
            $new_item['attribute_value_img'] = $attribute_value_img_arr[$item['attribute_value_id']];
            $out[] = $new_item;
        }

        return $out;
    }


    /** получаем комбинацию товара */
    public static function getOneProductCombination($product_combination_id) {
        if ($product_combination_id == 0) {
            return null;
        } else {
            $db = Yii::$app->db;
            $product_combination = $db->createCommand('
                SELECT
                    product_combination.id,
                    product_combination.img,
                    product_combination.parent_id,
                    product_combination.kode,
                    product_combination.price,
                    attribute_list.name_'.Yii::$app->language.' AS a_name,
                    attribute_value.name_'.Yii::$app->language.' AS v_name
                FROM product_combination
                INNER JOIN attribute_list
                    ON product_combination.attribute_id=attribute_list.id
                INNER JOIN attribute_value
                    ON product_combination.attribute_value_id=attribute_value.id
                WHERE product_combination.id = '.$product_combination_id.'
            ')->queryOne();

            return $product_combination;
        }
    }

}
