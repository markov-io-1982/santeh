<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
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
 */
class Order extends \yii\db\ActiveRecord
{

    public $np;
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
            [['delivery_method_id', 'payment_metod_id', 'user_name', 'user_lastname', 'user_email', 'user_phone'], 'required'],
            [['delivery_method_id', 'payment_metod_id', 'order_status_id', 'type'], 'integer'],
            [['total_sum'], 'number'],
            [['date_create', 'date_payment'], 'safe'],
            [['code'], 'string', 'max' => 255],
            [['user_id', 'user_name', 'user_middlename', 'user_lastname', 'user_email'], 'string', 'max' => 100],
            //[['user_phone'], 'number', 'min' => 10],
            [['user_phone'], 'number'],
            [['user_adress'], 'string', 'max' => 1000],
            [['user_comment'], 'string', 'max' => 2000],
            ['user_email', 'email'],
            ['np', 'safe'],
            ['np', 'my_required'],
            ['user_adress', 'my_required2'],
            [['code'], 'filter', 'filter' => function ($value) {
                $last_id = Order::find()->select(['id'])->orderBy('id DESC')->one();
                if (count($last_id) == 0) {$last_id = 0;}
                $last_id = $last_id['id'] + 1;
                return $last_id . '-' . date('Ymd');
            }],
            [['user_id'], 'filter', 'filter' => function ($value) {
                return Yii::$app->session->get('user_id');
            }],
            ['user_adress', 'filter', 'filter' => function () {
                if ($this->user_adress == '' && $this->np == '') {
                    return \frontend\models\S::getCont('office_adress');
                }
                else {
                    $address = ($this->user_adress == '') ? $this->np : $this->user_adress; 
                    return $address;                    
                }
            }]
        ];
    }

    public function my_required($attribute_name, $params) {
        if ($this->delivery_method_id == 1 && $this->np == '' && $this->isNewRecord) {
            $this->addError($attribute_name, 'Выберите адрес отделения');
            return false;
        }
        return true;
    }

    public function my_required2($attribute_name, $params) {
        if ($this->delivery_method_id != 1 && $this->delivery_method_id != 3 && $this->user_adress == '' && $this->isNewRecord ) {
            $this->addError($attribute_name, 'Поле "Адрес" не может быть пустым');
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'user_id' => Yii::t('app', 'User ID'),
            'delivery_method_id' => Yii::t('app', 'Delivery Method'),
            'payment_metod_id' => Yii::t('app', 'Payment Metod'),
            'user_name' => Yii::t('app', 'User Name'),
            'user_middlename' => Yii::t('app', 'Middlename'),
            'user_lastname' => Yii::t('app', 'Lastname'),
            'user_email' => Yii::t('app', 'Email'),
            'user_phone' => Yii::t('app', 'Phone'),
            'user_adress' => Yii::t('app', 'Adress'),
            'user_comment' => Yii::t('app', 'Comment'),
            'total_sum' => Yii::t('app', 'Total Sum'),
            'order_status_id' => Yii::t('app', 'Order Status'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_payment' => Yii::t('app', 'Date Payment'),
        ];
    }


}
