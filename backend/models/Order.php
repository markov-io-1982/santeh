<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use backend\models\Cart;
use backend\models\Product;
use backend\models\ProductCombination;
use backend\models\Order;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $code
 * @property string $user_id
 * @property integer $delivery_method_id
 * @property integer $payment_metod_id
 * @property string $user_name
 * @property string $user_middlename
 * @property string $user_lastname
 * @property string $user_email
 * @property string $user_phone
 * @property string $user_adress
 * @property string $user_comment
 * @property string $total_sum
 * @property integer $order_status_id
 * @property string $date_create
 * @property string $date_payment
 * @property string $currency
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'user_id', 'total_sum', 'order_status_id', 'date_create'], 'required'],
            [['delivery_method_id', 'payment_metod_id', 'order_status_id', 'type'], 'integer'],
            [['total_sum'], 'number'],
            [['date_create', 'date_payment'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            [['user_id', 'user_name', 'user_middlename', 'user_lastname', 'user_email'], 'string', 'max' => 100],
            [['user_phone'], 'string', 'max' => 15],
            [['user_adress'], 'string', 'max' => 1000],
            [['user_comment'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'user_id' => Yii::t('app', 'User'),
            'delivery_method_id' => Yii::t('app', 'Delivery Method'),
            'payment_metod_id' => Yii::t('app', 'Payment Metod'),
            'user_name' => Yii::t('app', 'User Name'),
            'user_middlename' => Yii::t('app', 'User Middlename'),
            'user_lastname' => Yii::t('app', 'User Lastname'),
            'user_email' => Yii::t('app', 'Email'),
            'user_phone' => Yii::t('app', 'Phone'),
            'user_adress' => Yii::t('app', 'Adress'),
            'user_comment' => Yii::t('app', 'Comment'),
            'total_sum' => Yii::t('app', 'Total Sum'),
            'order_status_id' => Yii::t('app', 'Order Status'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_payment' => Yii::t('app', 'Date Payment'),
            'type' => Yii::t('app', 'Order Type'),
            'currency' => Yii::t('app', 'Валюта'),

        ];
    }

    public function getDeliveryMethod()
    {
        return $this->hasOne(DeliveryMethod::className(), ['id' => 'delivery_method_id']);
    }

    public function getPaymentMethod()
    {
        return $this->hasOne(PaymentMethod::className(), ['id' => 'delivery_method_id']);
    }

    public function getOrderStatus()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'order_status_id']);
    }

    public function getType ($type)
    {
        $types = [
            '0' => 'Standart',
            '1' => 'One Click',
        ];

        return $types[$type];
    }

    public function getProductsInOrder($order_id)
    {
        $db = Yii::$app->db;
        $products = $db->createCommand('
            SELECT
                cart.amount,
                cart.price,
                cart.product_id,
                product.name_'.Yii::$app->language.' AS name,
                product.kode,
                product_combination.attribute_id,
                product_combination.attribute_value_id,
                cart.product_comb_id
            FROM cart
            INNER JOIN product
                ON cart.product_id=product.id
            LEFT JOIN product_combination
                ON cart.product_comb_id=product_combination.id
            WHERE cart.order_id = '.$order_id.'
        ')->queryAll();


        // $product_ids = ArrayHelper::getColumn($carts, 'product_id');
        // $product_combination_ids = ArrayHelper::getColumn($carts, 'product_comb_id');

        // $products = Product::find()->where(['id' => $product_ids])->all();

        $products_arr = [];
        foreach ($products as $product) {
            $item = [];
            $item['amount'] = $product['amount'];
            $item['product_id'] = $product['product_id'];
            $item['price'] = $product['price'];
            $item['name'] = $product['name'];
            $item['kode'] = $product['kode'];
            $item['combination'] = ProductCombination::getOneProductCombination($product['product_comb_id']);
            $products_arr[] = $item;
        }

        $out = '<table class="table">';
        $out .= '<tr>';
            $out .= '<th>'. Yii::t('app', 'Products') .'</th>';
            $out .= '<th>'. Yii::t('app', 'Art.') .'</th>';
            $out .= '<th>' . Yii::t('app', 'Amount') . '</th>';
            $out .= '<th>'. Yii::t('app', 'Price') .'</th>';
            $out .= '<th>'. Yii::t('app', 'Total price') .'</th>';
            $out .= '<th><i class="fa fa-eye"></i></th>';
        $out .= '</tr>';

        foreach ($products_arr as $p) {
            $out .= '<tr>';
            $p_comb = '';
            $p_kode = $p['kode'];
            if($p['combination']) {
                $p_comb = ' ( ' . $p['combination']['a_name'] . '-' . $p['combination']['v_name'] . ' )';
                $p_kode .= '( '. $p['combination']['kode'] . ')';
            }

            $out .= '<td>'.$p['name']. $p_comb .'</td>';
            $out .= '<td>'.$p_kode.'</td>';
            $out .= '<td>'.$p['amount'].'</td>';
            $out .= '<td>'.$p['price'].'</td>';
            $out .= '<td>'.$p['price'] * $p['amount'].'</td>';

            $out .= '<td>'.Html::a('<i class="fa fa-eye"></i>', ['/product/view','id'=>$p['product_id']], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'View')]) .'</td>';

            $out .= '</tr>';
        }
        $out .= '</table>';

        return $out;

    }

}
