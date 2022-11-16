<?php

namespace frontend\models;

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
            'product_id' => Yii::t('app', 'Product ID'),
            'product_comb_id' => Yii::t('app', 'Product Comb ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'amount' => Yii::t('app', 'Amount'),
            'price' => Yii::t('app', 'Price'),
            'date' => Yii::t('app', 'Date'),
            'order_id' => Yii::t('app', 'Order ID'),
        ];
    }

    public static function initCart() {
        if (Yii::$app->session->get('user_id')) {
            $user_cart = Cart::find()
                ->select(['amount', 'price'])
                ->where(['user_id' => Yii::$app->session->get('user_id'), 'order_id' => 0])
                ->all();

            $count = 0;
            $total_price = 0;

            if (count($user_cart) > 0) {
                foreach ($user_cart as $item) {
                    $count += $item->amount;
                    $total_price += $item->price;
                }
            }

            return [
                'count' => $count,
                'total_price' => $total_price,
            ];        
        } 
        else {
            return [
                'count' => 0,
                'total_price' => 0,
            ];
        }

    }

}
