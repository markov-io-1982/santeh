<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
 * @property integer $default_check
 * @property integer $attribute_id
 * @property integer $attribute_value_id
 * @property integer $buy
 * @property number $price
 * @property number $price_old
 * @property string $kode
 */
class ProductCombination extends \yii\db\ActiveRecord
{
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
            [['img', 'quantity', 'reserve', 'date_create', 'parent_id', 'attribute_id', 'attribute_value_id', 'buy'], 'required'],
            [['quantity', 'reserve', 'status', 'parent_id', 'sort_position', 'default_check', 'attribute_id', 'attribute_value_id', 'buy'], 'integer'],
            [['date_create'], 'safe'],
            [['price', 'price_old'], 'number'],
            [['kode'], 'string', 'max' => 50],
            [['img'], 'string', 'max' => 1000],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'default_check' => Yii::t('app', 'Default Check'),
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'attribute_value_id' => Yii::t('app', 'Attribute Value ID'),
            'buy' => Yii::t('app', 'Buy'),
            'kode' => Yii::t('app', 'Kode'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
        ];
    }

    public static function getProductCombinationToProductID($product_id) {

        $curent_product_combination = ProductCombination::find()
            ->where(['parent_id' => $product_id, 'status' => 1, 'default_check' => 1])
            ->andWhere('(quantity-reserve)>0')
            ->orderBy(['sort_position' => SORT_ASC])
            ->one();

        if (count($curent_product_combination) == 0) {
            $curent_product_combination = ProductCombination::find()
                ->where(['parent_id' => $product_id, 'status' => 1])
                ->andWhere('(quantity-reserve)>0')
                ->orderBy(['sort_position' => SORT_ASC])
                ->one();
        }
        if (count($curent_product_combination) == 0) {
            return false;
        }
        else {
            return $curent_product_combination;
        }
    }

    public static function getProductCombinationArrayToProductID($product_id) {
        // комбинации (виды) текущего продукта
        $product_combinations = ProductCombination::find()
            ->select(['id', 'img', 'quantity', 'reserve',
                        'default_check',
                        'attribute_id', 'attribute_value_id',
                        'kode', 'price', 'price_old',
                        ])
            ->where(['parent_id' => $product_id, 'status' => 1])
            ->andWhere(['>', 'quantity', 0])
            ->orderBy('sort_position')
            ->all();

        // ID атрибутов
        $attribute_ids = ArrayHelper::getColumn($product_combinations, 'attribute_id');
        // ID значение атрибутов
        $attribute_value_ids = ArrayHelper::getColumn($product_combinations, 'attribute_value_id');

        // выборка атрибутов по ранее полученым ID
        $attributes = AttributeList::find()
            ->select([
                'id',
                'name_'.Yii::$app->language,
            ])
            ->where(['id' => $attribute_ids])
            ->orderBy('sort_position')
            ->all();

        // формирование масива ID => атрибут
        $attributes_arr = ArrayHelper::map($attributes, 'id', 'name_'.Yii::$app->language);

        // выборка значений атрибутов
        $attribute_values = AttributeValue::find()
            ->select([
                'id',
                'name_'.Yii::$app->language,
                'attribute_id',
                'img',
            ])
            ->where(['id' => $attribute_value_ids])
            ->orderBy('sort_position')
            ->all();

        // формирования массива ID => [значение атрибута...]
        $attribute_values_arr = ArrayHelper::index($attribute_values, 'id');

        // формирования массива комбинаций (видов) продукта
        $product_combinations_arr = [];
        foreach ($product_combinations as $product_comb) {
            $item = [];
            $item['id'] = $product_comb->id;
            $item['img'] = $product_comb->img;
            $item['quantity'] = $product_comb->quantity;
            $item['reserve'] = $product_comb->reserve;
            $item['kode'] = $product_comb->kode;
            $item['price'] = $product_comb->price;
            $item['price_old'] = $product_comb->price_old;
            $item['default_check'] = $product_comb->default_check;
            $item['attribute'] = $attributes_arr[$product_comb->attribute_id];
            $item['attribute_value'] = $attribute_values_arr[$product_comb->attribute_value_id]['name_'.Yii::$app->language];
            $item['attribute_value_img'] = $attribute_values_arr[$product_comb->attribute_value_id]['img'];
            $product_combinations_arr[] = $item;
        }

        return $product_combinations_arr;
    }

    public static function getProductCombinationToCombinationID($id) {
    }

}
