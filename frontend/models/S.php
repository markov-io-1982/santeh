<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $code
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $content_en
 * @property string $content_ru
 * @property string $content_ua
 * @property string $date_create
 */
class S extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name_en', 'name_ru', 'name_ua', 'content_en', 'content_ru', 'content_ua', 'date_create'], 'required'],
            [['date_create'], 'safe'],
            [['code'], 'string', 'max' => 50],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 100],
            [['content_en', 'content_ru', 'content_ua'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name_en' => Yii::t('app', 'Name En'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'content_en' => Yii::t('app', 'Content En'),
            'content_ru' => Yii::t('app', 'Content Ru'),
            'content_ua' => Yii::t('app', 'Content Ua'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }

    public static function getCont($code)
    {
        $content = 'content_'.Yii::$app->language;
        return S::findOne(['code' => $code])->$content;
    }
}
