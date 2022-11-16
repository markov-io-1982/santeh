<?php

namespace backend\models;

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
            [['name_' . Yii::$app->language], 'required'],
            [['category_id', 'sort_position', 'as_filter'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 255],
            [['category_id', 'as_filter'], 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $value = 0;
                }
                return $value;
            }],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = AttributeList::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
            // [['name_en', 'name_ru', 'name_ua'], 'filter', 'filter' => function ($value) {
            //     if ($value == '') {
            //         $name = 'name_' . Yii::$app->language;
            //         $value = $this->$name;
            //     }
            //     return $value;
            // }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_en' => Yii::t('app', 'Name in English'),
            'name_ru' => Yii::t('app', 'Name in Russian'),
            'name_ua' => Yii::t('app', 'Name in Ukrainian'),
            'category_id' => Yii::t('app', 'Category'),
            'sort_position' => Yii::t('app', 'Order number'),
            'as_filter' => Yii::t('app', 'Use the filter'),
        ];
    }


    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function getAttributeListName($attribute_id)
    {
        $attribute = AttributeList::findOne(['id' => $attribute_id]);
        $name = 'name_'.Yii::$app->language;
        if (empty($attribute)) {
            return null;
        } else {
            return $attribute->$name;
        }        
    }

}
