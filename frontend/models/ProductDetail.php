<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product_detail".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $description_en
 * @property string $description_ru
 * @property string $description_ua
 * @property string $complectation_en
 * @property string $complectation_ru
 * @property string $complectation_ua
 * @property string $seo_title_en
 * @property string $seo_title_ru
 * @property string $seo_title_ua
 * @property string $seo_description_en
 * @property string $seo_description_ru
 * @property string $seo_description_ua
 * @property string $seo_keywords_en
 * @property string $seo_keywords_ru
 * @property string $seo_keywords_ua
 * @property string $seo_canonical_url
 * @property integer $buy
 * @property integer $count_views
 */
class ProductDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'description_en', 'description_ru', 'description_ua', 'complectation_en', 'complectation_ru', 'complectation_ua', 'seo_title_en', 'seo_title_ru', 'seo_title_ua', 'seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua', 'seo_canonical_url'], 'required'],
            [['product_id', 'buy', 'count_views'], 'integer'],
            [['description_en', 'description_ru', 'description_ua', 'complectation_en', 'complectation_ru', 'complectation_ua'], 'string'],
            [['seo_title_en', 'seo_title_ru', 'seo_title_ua'], 'string', 'max' => 255],
            [['seo_description_en', 'seo_description_ru', 'seo_description_ua', 'seo_keywords_en', 'seo_keywords_ru', 'seo_keywords_ua'], 'string', 'max' => 200],
            [['seo_canonical_url'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'description_en' => Yii::t('app', 'Description En'),
            'description_ru' => Yii::t('app', 'Description Ru'),
            'description_ua' => Yii::t('app', 'Description Ua'),
            'complectation_en' => Yii::t('app', 'Complectation En'),
            'complectation_ru' => Yii::t('app', 'Complectation Ru'),
            'complectation_ua' => Yii::t('app', 'Complectation Ua'),
            'seo_title_en' => Yii::t('app', 'Seo Title En'),
            'seo_title_ru' => Yii::t('app', 'Seo Title Ru'),
            'seo_title_ua' => Yii::t('app', 'Seo Title Ua'),
            'seo_description_en' => Yii::t('app', 'Seo Description En'),
            'seo_description_ru' => Yii::t('app', 'Seo Description Ru'),
            'seo_description_ua' => Yii::t('app', 'Seo Description Ua'),
            'seo_keywords_en' => Yii::t('app', 'Seo Keywords En'),
            'seo_keywords_ru' => Yii::t('app', 'Seo Keywords Ru'),
            'seo_keywords_ua' => Yii::t('app', 'Seo Keywords Ua'),
            'seo_canonical_url' => Yii::t('app', 'Seo Canonical Url'),
            'buy' => Yii::t('app', 'Buy'),
            'count_views' => Yii::t('app', 'Count Views'),
        ];
    }
}
