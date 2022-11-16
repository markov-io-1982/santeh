<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $product_comb_id
 * @property string $user_id
 * @property integer $amount
 * @property string $price
 * @property string $date
 * @property integer $order_id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'product_comb_id', 'user_id', 'amount', 'price', 'date', 'order_id'], 'required'],
            [['product_id', 'product_comb_id', 'amount', 'order_id'], 'integer'],
            [['price'], 'number'],
            [['date'], 'safe'],
            [['user_id'], 'string', 'max' => 50],
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
            'product_comb_id' => Yii::t('app', 'Product Combination'),
            'user_id' => Yii::t('app', 'User'),
            'amount' => Yii::t('app', 'Amount'),
            'price' => Yii::t('app', 'Price'),
            'date' => Yii::t('app', 'Date'),
            'order_id' => Yii::t('app', 'Order'),
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductComb()
    {
        return $this->hasOne(ProductCombination::className(), ['id' => 'product_comb_id']);
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
