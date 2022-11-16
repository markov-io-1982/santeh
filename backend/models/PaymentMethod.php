<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "payment_method".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $description_en
 * @property string $description_ru
 * @property string $description_ua
 * @property integer $sort_position
 */
class PaymentMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language], 'required'],
            [['sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 255],
            [['description_en', 'description_ru', 'description_ua'], 'string', 'max' => 1000],
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
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '' || $value <= 0) {
                    $max = PaymentMethod::find()->orderBy('sort_position DESC')->one();
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
            'name_en' => Yii::t('app', 'Name En'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'description_en' => Yii::t('app', 'Description En'),
            'description_ru' => Yii::t('app', 'Description'),
            'description_ua' => Yii::t('app', 'Description Ua'),
            'sort_position' => Yii::t('app', 'Order number'),
        ];
    }
}
