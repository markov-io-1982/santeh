<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;
use backend\models\RelationsProductProduct;
use frontend\models\Category;

use Yii;

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
 * @property string $date_update
 * @property string $date_create
 * @property integer $isset_product_combination
 * @property string $kode
 */
class Product extends \yii\db\ActiveRecord
{
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
            [['name_en', 'name_ru', 'name_ua', 'category_id', 'intro_text_en', 'intro_text_ru', 'intro_text_ua', 'price', 'price_old', 'quantity', 'min_order', 'reserve', 'promo_status_id', 'promo_date_end', 'stock_status_id', 'img', 'slug', 'date_update', 'date_create'], 'required'],
            [['category_id', 'sort_position', 'quantity', 'min_order', 'reserve', 'promo_status_id', 'stock_status_id', 'on_main', 'status', 'isset_product_combination'], 'integer'],
            [['price', 'price_old'], 'number'],
            [['promo_date_end', 'date_update', 'date_create'], 'safe'],
            [['name_en', 'name_ru', 'name_ua', 'slug'], 'string', 'max' => 255],
            [['kode'], 'string', 'max' => 50],
            [['intro_text_en', 'intro_text_ru', 'intro_text_ua', 'img'], 'string', 'max' => 1000],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'intro_text_en' => Yii::t('app', 'Intro Text En'),
            'intro_text_ru' => Yii::t('app', 'Intro Text Ru'),
            'intro_text_ua' => Yii::t('app', 'Intro Text Ua'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
            'quantity' => Yii::t('app', 'Quantity'),
            'min_order' => Yii::t('app', 'Min Order'),
            'reserve' => Yii::t('app', 'Reserve'),
            'promo_status_id' => Yii::t('app', 'Promo Status ID'),
            'promo_date_end' => Yii::t('app', 'Promo Date End'),
            'stock_status_id' => Yii::t('app', 'Stock Status ID'),
            'img' => Yii::t('app', 'Img'),
            'on_main' => Yii::t('app', 'On Main'),
            'slug' => Yii::t('app', 'Slug'),
            'status' => Yii::t('app', 'Status'),
            'date_update' => Yii::t('app', 'Date Update'),
            'date_create' => Yii::t('app', 'Date Create'),
            'isset_product_combination' => Yii::t('app', 'Isset Product Combination'),
            'kode' => Yii::t('app', 'Kode'),
        ];
    }

    public static function getSortBy($sort_by) {
        if ($sort_by == 'name_asc') {
            $sort = 'name_'.Yii::$app->language . ' ASC';
        } else if ($sort_by == 'name_desc') {
            $sort = 'name_'.Yii::$app->language . ' DESC';
        } else if ($sort_by == 'price_asc') {
            $sort = 'price ASC';
        } else if ($sort_by == 'price_desc') {
            $sort = 'price DESC';
        } else if ($sort_by == 'ratings_asc') {
            $sort = 'count_stars ASC';
        } else if ($sort_by == 'ratings_desc') {
            $sort = 'count_stars DESC';
        }

        return $sort;
    }


    /* получаем связанные продукты в виде масива id(relation) => name */
    public static function getAllReationsProduct($id) {
        $relation_product = RelationsProductProduct::find()->where(['product_main_id' => $id])->all();

        // id | product_main_id | product_rel_id

        $product_ids = ArrayHelper::getColumn($relation_product, 'product_rel_id'); // Id связанных продуктов


        $products = Product::find()
            ->select([
                'id',
                'name_' . Yii::$app->language,
                'slug',
                'category_id',
                'img'
                ])
            ->where(['id' => $product_ids])
            ->all();

        $category_ids = ArrayHelper::getColumn($products, 'category_id');
        $category = Category::find()->where(['id' => $category_ids])->all();
        $category_arr = ArrayHelper::map($category, 'id', 'slug');

        // id | name

        $product_array = [];
        $name = 'name_'.Yii::$app->language;
        foreach ($products as $product) {
            $item = [];
            $item['id'] = $product->id;
            $item['name'] = $product->$name;
            $item['slug'] = $product->slug;
            $item['category'] = $category_arr[$product->category_id];
            $item['img'] = $product->img;
            $product_array[] = $item;
        }

        return $product_array;
        //return $category_ids;

    }

}
