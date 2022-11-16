<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "attribute_list".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $category_id
 * @property integer $sort_position
 * @property integer $as_filter
 */
class AttributeList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attribute_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_en', 'name_ru', 'name_ua', 'category_id'], 'required'],
            [['category_id', 'sort_position', 'as_filter'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 255],
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
            'category_id' => Yii::t('app', 'Category ID'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'as_filter' => Yii::t('app', 'As Filter'),
        ];
    }
}
