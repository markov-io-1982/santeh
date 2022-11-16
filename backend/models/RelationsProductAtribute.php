<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\AttributeList;
use backend\models\AttributeValue;
use backend\models\Product;

/**
 * This is the model class for table "relations_product_atribute".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property integer $attribute_value_id
 */
class RelationsProductAtribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relations_product_atribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'attribute_id', 'attribute_value_id'], 'required'],
            [['product_id', 'attribute_id', 'attribute_value_id'], 'integer'],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = RelationsProductAtribute::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product'),
            'attribute_id' => Yii::t('app', 'Attribute'),
            'attribute_value_id' => Yii::t('app', 'Attribute Value'),
            'sort_position' => Yii::t('app', 'Sort Position'),
        ];
    }

    /* получаем связанные продукты в виде 1 => [id => id, attribute => attribute, value => value, img => img, sort => sort] */
    public static function getReationsAtribute($id) {

        // 1. получаем массив автрибутов даного товара
        $relation_product = RelationsProductAtribute::find()->where(['product_id' => $id])->orderBy('sort_position')->all();

        // 2. получаем массив названия атрибутов: id => attribute
        $attributes = AttributeList::find()->all();

        $attributes_array = [];
        foreach($attributes as $attribute) {
            $name = 'name_' . Yii::$app->language;
            $attributes_array[$attribute->id] = $attribute->$name;
        }

        // 3. получаем масив значения атрибутов 
        $attributes_value = AttributeValue::find()->all();

        $attributes_value_array = [];
        $attributes_imags_array = [];
        foreach ($attributes_value as $attribute_value) {
            $name = 'name_' . Yii::$app->language;
            $attributes_value_array[$attribute_value->id] = $attribute_value->$name;
            $attributes_imags_array[$attribute_value->id] = $attribute_value->img;            
        }

        // 4. формируем нужный массив
        $relation_array = [];
        foreach ($relation_product as $rel) {
            $item = [];
            $item['id'] = $rel->id;
            $item['attribute'] = $attributes_array[$rel->attribute_id];
            $item['value'] = $attributes_value_array[$rel->attribute_value_id];
            $item['img'] = $attributes_imags_array[$rel->attribute_value_id];
            $item['sort'] = $rel->sort_position;

            $relation_array[] = $item;
        }

        return $relation_array;

    }

    // получить список доступных аттрибутов для категории в которой находится данный товар
    public function getAttributesFoCategory() {

        $cat_id = Product::findOne(['id' => $this->product_id])->category_id;

        $attribute_arr = AttributeList::find()
            ->where(['category_id' => [0, $cat_id]])
            ->all();

        return ArrayHelper::map($attribute_arr, 'id', 'name_' . Yii::$app->language );
    }

}
