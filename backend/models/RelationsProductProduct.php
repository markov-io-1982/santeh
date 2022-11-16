<?php

namespace backend\models;

use Yii;
use backend\models\Product;
use backend\models\RelationsProductProduct;


/**
 * This is the model class for table "relations_product_product".
 *
 * @property integer $id
 * @property integer $product_main_id
 * @property integer $product_rel_id
 */
class RelationsProductProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relations_product_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['product_main_id', 'product_rel_id'], 'required'],
            [['product_main_id', 'product_rel_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_main_id' => Yii::t('app', 'Product Main ID'),
            'product_rel_id' => Yii::t('app', 'Product'),
        ];
    }

    /* получаем связанные продукты в виде масива id(relation) => name */
    public static function getReationsProduct($id) {
        $relation_product = RelationsProductProduct::find()->where(['product_main_id' => $id])->all();

        // id | product_main_id | product_rel_id

        $product_ids = [];
        $rel_ids = [];
        foreach ($relation_product as $product) {
            $product_ids[] = $product->product_rel_id;
            $rel_ids[] = $product->id;
        }

        $products = Product::find()->select(['id', 'name_' . Yii::$app->language])->where(['id' => $product_ids])->all();

        // id | name

        $product_array = [];
        foreach ($products as $item) {
            $name = 'name_' . Yii::$app->language;
            $product_array[$item->id] = $item->$name;
        }

        $total_product = [];

        foreach ($relation_product as $item) {
            $total_product[$item->id] = $product_array[$item->product_rel_id];
        }

        return $total_product;
    }

}
