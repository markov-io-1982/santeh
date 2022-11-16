<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "payment_pb".
 *
 * @property integer $id
 * @property string $amt
 * @property string $ccy
 * @property string $merchant
 * @property integer $order_id
 * @property string $order
 * @property string $details
 * @property string $ext_details
 * @property string $pay_way
 * @property string $state
 * @property string $ref
 * @property string $note
 * @property string $sender_phone
 * @property string $pay_status
 * @property string $date_create
 * @property string $date_update
 */
class PaymentPb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_pb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['amt', 'ccy', 'merchant', 'order_id', 'order', 'details', 'ext_details', 'pay_way', 'state', 'ref', 'note', 'sender_phone', 'pay_status', 'date_create', 'date_update'], 'required'],
            [['order_id'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['ccy'], 'string', 'max' => 10],
            [['amt', 'amt_total'], 'string', 'max' => 20],
            [['merchant', 'pay_way', 'pay_status'], 'string', 'max' => 50],
            [['order', 'ref'], 'string', 'max' => 100],
            [['details'], 'string', 'max' => 255],
            [['ext_details', 'note'], 'string', 'max' => 1000],
            [['state', 'sender_phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'amt' => Yii::t('app', 'Amt'),
            'amt_total' => Yii::t('app', 'Amt'),
            'ccy' => Yii::t('app', 'Ccy'),
            'merchant' => Yii::t('app', 'Merchant'),
            'order_id' => Yii::t('app', 'Order ID'),
            'order' => Yii::t('app', 'Order'),
            'details' => Yii::t('app', 'Details'),
            'ext_details' => Yii::t('app', 'Ext Details'),
            'pay_way' => Yii::t('app', 'Pay Way'),
            'state' => Yii::t('app', 'State'),
            'ref' => Yii::t('app', 'Ref'),
            'note' => Yii::t('app', 'Note'),
            'sender_phone' => Yii::t('app', 'Sender Phone'),
            'pay_status' => Yii::t('app', 'Pay Status'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_update' => Yii::t('app', 'Date Update'),
        ];
    }
}
