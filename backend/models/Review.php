<?php

namespace backend\models;

use Yii;
use backend\models\Product;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property integer $product_id
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
            [['product_id', 'user_name', 'review_text', 'stars'], 'required'],
            [['product_id', 'status', 'stars'], 'integer'],
            [['date_create'], 'safe'],
            [['user_id'], 'string', 'max' => 50],
            [['user_name'], 'string', 'max' => 100],
            [['review_text'], 'string', 'max' => 1000],
            ['user_id', 'filter', 'filter' => function ($value) {
                return Yii::$app->session->get('user_id');
            }],
            ['date_create', 'filter', 'filter' => function ($value) {
                return date('Y-m-d H:i:s');
            }],
            ['user_id', 'filter', 'filter' => function ($value) {
                if ($value == '') { return 'admin';}
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'review_text' => Yii::t('app', 'Text'),
            'date_create' => Yii::t('app', 'Date Create'),
            'status' => Yii::t('app', 'Active'),
            'stars' => Yii::t('app', 'Stars'),
        ];
    }

    public static function updateReviewsCounters($product_id) {

        $count_reviews = 0;
        $stars = 0;

        $reviews = Review::find()->select(['stars'])->where(['product_id' => $product_id, 'status' => 1])->all();
        $count_reviews = count($reviews);
        $stars_arr = ArrayHelper::getColumn($reviews, 'stars');
        $stars = ceil( array_sum($stars_arr) /  $count_reviews );

        $product = Product::findOne(['id' => $product_id]);
        $product->count_reviews = $count_reviews;
        $product->count_stars = $stars;
        $product->save(false);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

}
