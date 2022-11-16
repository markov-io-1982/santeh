<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "relations_product_atribute".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property integer $attribute_value_id
 * @property integer $sort_position
 */
class RelationsProductAtribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relations_product_atribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'attribute_id', 'attribute_value_id'], 'required'],
            [['product_id', 'attribute_id', 'attribute_value_id', 'sort_position'], 'integer'],
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
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'attribute_value_id' => Yii::t('app', 'Attribute Value ID'),
            'sort_position' => Yii::t('app', 'Sort Position'),
        ];
    }

    public static function getAttributesList ($product_id) {

        $db = Yii::$app->db;
        $product_attributes = $db->createCommand('
            SELECT relations_product_atribute.id,
                relations_product_atribute.sort_position,
                attribute_list.name_'.Yii::$app->language.' AS `a_name`,
                attribute_value.name_'.Yii::$app->language.' AS `v_name`,
                attribute_value.img
            FROM `relations_product_atribute`
            INNER JOIN `attribute_list`
            ON relations_product_atribute.attribute_id=attribute_list.id
            INNER JOIN `attribute_value`
            ON relations_product_atribute.attribute_value_id=attribute_value.id
            WHERE relations_product_atribute.product_id='.$product_id.'
            ORDER BY relations_product_atribute.sort_position ASC
        ')->queryAll();

        return $product_attributes;
    }

}
