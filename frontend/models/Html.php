<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "html_block".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $content_en
 * @property string $content_ru
 * @property string $content_ua
 * @property string $date_create
 * @property integer $status
 */
class Html extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'html_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name_en', 'name_ru', 'name_ua', 'content_en', 'content_ru', 'content_ua', 'date_create'], 'required'],
            [['content_en', 'content_ru', 'content_ua'], 'string'],
            [['date_create'], 'safe'],
            [['status'], 'integer'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 50],
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
            'code' => Yii::t('app', 'Code'),
            'content_en' => Yii::t('app', 'Content En'),
            'content_ru' => Yii::t('app', 'Content Ru'),
            'content_ua' => Yii::t('app', 'Content Ua'),
            'date_create' => Yii::t('app', 'Date Create'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public static function getCont($code)
    {
        $content = 'content_'.Yii::$app->language;
        return Html::findOne(['code' => $code, 'status' => 1])->$content;
    }
}
