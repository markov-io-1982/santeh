<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stock_status".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $sort_position
 */
class StockStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_' . Yii::$app->language], 'required'],
            [['sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 100],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = StockStatus::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
            [['name_en', 'name_ru', 'name_ua'], 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $name = 'name_' . Yii::$app->language;
                    $value = $this->$name;
                }
                return $value;
            }]
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
            'sort_position' => Yii::t('app', 'Sort Position'),
        ];
    }

    public static function getStockStatusName($stock_status_id)
    {
        $stock_status = PromoStatus::findOne(['id' => $stock_status_id]);
        if (empty($stock_status)) {
            return null;
        } else {
            $name = 'name_'.Yii::$app->language;
            return $stock_status->$name;    
        }
         
    }

}
