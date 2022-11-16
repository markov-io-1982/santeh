<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $user_name
 * @property string $user_id
 * @property string $review_text
 * @property string $date_create
 * @property integer $status
 * @property integer $stars
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'user_name', 'user_id', 'review_text', 'date_create', 'stars'], 'required'],
            [['product_id', 'status', 'stars'], 'integer'],
            [['date_create'], 'safe'],
            [['user_name'], 'string', 'max' => 100],
            [['user_id'], 'string', 'max' => 50],
            [['review_text'], 'string', 'max' => 1000],
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
            'user_name' => Yii::t('app', 'User Name'),
            'user_id' => Yii::t('app', 'User ID'),
            'review_text' => Yii::t('app', 'Review Text'),
            'date_create' => Yii::t('app', 'Date Create'),
            'status' => Yii::t('app', 'Status'),
            'stars' => Yii::t('app', 'Stars'),
        ];
    }
}
