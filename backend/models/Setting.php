<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $content
 * @property string $date_create
 */
class Setting extends \yii\db\ActiveRecord
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
            [['code'], 'required'],
            [['name_' . Yii::$app->language], 'required'],
            //[['content_' . Yii::$app->language], 'required'],
            [['date_create'], 'safe'],
            [['code'], 'string', 'max' => 50],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 100],
            [['content_en', 'content_ru', 'content_ua'], 'string', 'max' => 500],
            ['date_create', 'filter', 'filter' => function($value) {
                return date('Y-m-d H:i:s');
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
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'content' => Yii::t('app', 'Content'),
            'content_ru' => Yii::t('app', 'Content Ru'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }
}
