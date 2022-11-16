<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_wm".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $amt
 * @property string $details
 * @property string $payee_purse
 * @property string $payment_no
 * @property string $payment_amount
 * @property integer $mode
 * @property string $sys_invs_no
 * @property string $sys_trans_no
 * @property string $sys_trans_date
 * @property string $payer_purse
 * @property string $payer_wm
 * @property string $date_create
 * @property string $phone
 * @property integer $status
 * @property string $note
 */
class PaymentWm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_wm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['user_id', 'amt', 'details', 'payee_purse', 'payment_no', 'payment_amount', 'sys_invs_no', 'sys_trans_no', 'sys_trans_date', 'payer_purse', 'payer_wm', 'date_create', 'phone', 'status', 'note'], 'required'],
            [['mode', 'status'], 'integer'],
            [['sys_trans_date', 'date_create'], 'safe'],
            [['user_id', 'payee_purse', 'payer_wm'], 'string', 'max' => 100],
            [['amt', 'payment_amount', 'payer_purse', 'phone'], 'string', 'max' => 20],
            [['details', 'payment_no', 'sys_invs_no', 'sys_trans_no'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'amt' => Yii::t('app', 'Amt'),
            'details' => Yii::t('app', 'Details'),
            'payee_purse' => Yii::t('app', 'Payee Purse'),
            'payment_no' => Yii::t('app', 'Payment No'),
            'payment_amount' => Yii::t('app', 'Payment Amount'),
            'mode' => Yii::t('app', 'Mode'),
            'sys_invs_no' => Yii::t('app', 'Sys Invs No'),
            'sys_trans_no' => Yii::t('app', 'Sys Trans No'),
            'sys_trans_date' => Yii::t('app', 'Sys Trans Date'),
            'payer_purse' => Yii::t('app', 'Payer Purse'),
            'payer_wm' => Yii::t('app', 'Payer Wm'),
            'date_create' => Yii::t('app', 'Date Create'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'note' => Yii::t('app', 'Note'),
        ];
    }
}
