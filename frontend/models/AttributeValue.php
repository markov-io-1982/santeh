<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attribute_value".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $attribute_id
 * @property string $img
 * @property integer $sort_position
 * @property string $slug
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_en', 'name_ru', 'name_ua', 'attribute_id', 'img', 'slug'], 'required'],
            [['attribute_id', 'sort_position'], 'integer'],
            [['name_en', 'name_ru', 'name_ua', 'slug'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 1000],
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
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'img' => Yii::t('app', 'Img'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }
}
