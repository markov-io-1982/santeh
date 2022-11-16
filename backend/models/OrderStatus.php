<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order_status".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $payment_success
 */
class OrderStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language], 'required'],
            [['payment_success'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 255],
            // [['name_en', 'name_ru', 'name_ua'], 'filter', 'filter' => function ($value) {
            //     if ($value == '') {
            //         $name = 'name_' . Yii::$app->language;
            //         $value = $this->$name;
            //     }
            //     return $value;
            // }],
            // [['description_en', 'description_ru', 'description_ua'], 'filter', 'filter' => function ($value) {
            //     if ($value == '') {
            //         $name = 'description_' . Yii::$app->language;
            //         $value = $this->$name;
            //     }
            //     return $value;
            // }],            
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
            'payment_success' => Yii::t('app', 'Payment Success'),
        ];
    }

    public static function getStatusNew () {
        return 2;
    }

    public static function changeStatus ($prev_status, $new_status) {
        if ($prev_status == 2 && $new_status == 1) {
            return true;
        } else {
            return false;
        }
    }

}
