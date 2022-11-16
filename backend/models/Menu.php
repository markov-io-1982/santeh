<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_ua
 * @property string $url
 * @property integer $parent_id
 * @property integer $status
 * @property integer $sort_position
 * @property string $date_create
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['name_' . Yii::$app->language], 'required'],
            [['parent_id', 'status', 'sort_position'], 'integer'],
            [['date_create'], 'safe'],
            [['name_en', 'name_ru', 'name_ua'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 1000],
            ['date_create', 'filter', 'filter' => function($value) {
                return date('Y-m-d H:i:s');
            }],
            ['parent_id', 'filter', 'filter' => function ($value) {
                return ($value == '') ? 0 : $value;
            }],
            ['parent_id', 'validateParentMenu'],
            ['sort_position', 'filter', 'filter' => function ($value) {
                if ($value == '') {
                    $max = Menu::find()->orderBy('sort_position DESC')->one();
                    if (count($max) > 0) {
                        $value = $max->sort_position + 1;
                    } else {
                        $value = 1;
                    }
                }
                return $value;
            }],
        ];
    }

    public function validateParentMenu($attribute, $params)
    {
        
        if ($this->$attribute != 0) { // если есть родитель
            $parent_menu = Menu::findOne(['id' => $this->$attribute]); // получаем родителя
            if ($parent_menu['parent_id'] != 0) { // если есть родитель
                $parent_parent_menu = Menu::findOne(['id' => $parent_menu['parent_id']]);
                if ($parent_parent_menu['parent_id'] == 0) {
                    $this->addError($attribute, 'Слишком большая вложеность');
                }
            }
        }
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
            'parent_id' => Yii::t('app', 'Parent'),
            'status' => Yii::t('app', 'Status'),
            'sort_position' => Yii::t('app', 'Order number'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }
}
