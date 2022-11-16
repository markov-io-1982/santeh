<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $parent_id
 * @property integer $sort_position
 * @property string $slug
 * @property string $seo_title_en
 * @property string $seo_title_ru
 * @property string $seo_title_ua
 * @property string $seo_description_en
 * @property string $seo_description_ru
 * @property string $seo_description_ua
 * @property string $seo_keywords_en
 * @property string $seo_keywords_ru
 * @property string $seo_keywords_ua
 * @property string $date_create
 * @property string $date_update
 * @property integer $status
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_en', 'name_ru', 'name_ua', 'slug', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua', 'date_create', 'date_update', 'description'], 'required'],
            [['parent_id', 'sort_position', 'status'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['name_en', 'name_ru', 'name_ua', 'slug', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'img'], 'string', 'max' => 255],
            [['seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua'], 'string', 'max' => 200],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'sort_position' => Yii::t('app', 'Sort Position'),
            'slug' => Yii::t('app', 'Slug'),
            'img' => Yii::t('app', 'Images'),
            'seo_title_en' => Yii::t('app', 'Seo Title En'),
            'seo_title_ru' => Yii::t('app', 'Seo Title Ru'),
            'seo_title_ua' => Yii::t('app', 'Seo Title Ua'),
            'seo_description_en' => Yii::t('app', 'Seo Description En'),
            'seo_description_ru' => Yii::t('app', 'Seo Description Ru'),
            'seo_description_ua' => Yii::t('app', 'Seo Description Ua'),
            'seo_keywords_en' => Yii::t('app', 'Seo Keywords En'),
            'seo_keywords_ru' => Yii::t('app', 'Seo Keywords Ru'),
            'seo_keywords_ua' => Yii::t('app', 'Seo Keywords Ua'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_update' => Yii::t('app', 'Date Update'),
            'status' => Yii::t('app', 'Status'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
