<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $url
 * @property integer $product_id
 * @property integer $sort_position
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_en', 'name_ru', 'name_ua', 'url'], 'required'],
            [['product_id', 'sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 1000],
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
            'url' => Yii::t('app', 'Url'),
            'product_id' => Yii::t('app', 'Product ID'),
            'sort_position' => Yii::t('app', 'Sort Position'),
        ];
    }
}
