<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "code".
 *
 * @property integer $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $name_ua
 * @property string $content
 * @property string $code
 * @property integer $status
 * @property string $date
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en', 'name_ua', 'content', 'code', 'status', 'date'], 'required'],
            [['content'], 'string'],
            [['status'], 'integer'],
            [['date'], 'safe'],
            [['name_ru', 'name_en', 'name_ua'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'name_ua' => Yii::t('app', 'Name Ua'),
            'content' => Yii::t('app', 'Content'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    public static function getContent($code) {

        $content = Code::find()
            ->select(['content'])
            ->where(['code' => $code, 'status' => 1])
            ->one();

        return $content['content'];
    }
}
