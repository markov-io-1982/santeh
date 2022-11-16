<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

use frontend\models\Category;
use frontend\models\Product;
use frontend\models\ProductDetail;
use frontend\models\AttributeList;
use frontend\models\AttributeValue;
use frontend\models\RelationsProductAtribute;
use frontend\models\ProductImages;
use frontend\models\ProductCombination;
use frontend\models\Review;

/**
 * Shop controller
 */
class SitemapController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $urls = array();
        $host = Yii::$app->request->hostInfo;

        $categories = Category::find()
            ->select(['id', 'slug'])
            ->where(['status' => 1])
            ->all();

        foreach ($categories as $cat) {
           $urls[] = '/products/'.$cat->slug;
        }

        $categories_array = ArrayHelper::map($categories, 'id', 'slug');
        

        $products = Product::find()
            ->select(['id', 'category_id', 'slug'])
            ->where(['status' => 1])
            ->all();

        foreach ($products as $pr) {
            $urls[] = '/products/'. $categories_array[$pr->category_id] . '/' . $pr->slug;
        }


        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url){
            echo '<url>
                <loc>' . $host . $url . '</loc>
                <changefreq>daily</changefreq>
                <priority>0.5</priority>
            </url>';
        }
        echo '</urlset>'; 


    }


}
