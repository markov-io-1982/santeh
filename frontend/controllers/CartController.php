<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use frontend\models\Cart;
use frontend\models\Product;
use frontend\models\ProductCombination;
use common\models\Price;
use frontend\models\AttributeList;
use frontend\models\AttributeValue;
use frontend\models\Category;

/**
 * Shop controller
 */
class CartController extends Controller
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

        $model = Cart::find()
            ->where(['user_id' => Yii::$app->session->get('user_id'), 'order_id' => 0])
            ->all();

        $product_ids = [];
        $products_combination_ids = [];

        foreach ($model as $item) {             // получаем ID все продуктов в корзине (для даного пользователя)
            $product_ids[] = $item->product_id;
            $products_combination_ids[] = $item->product_comb_id;
        }

        $products = Product::find()
            ->select(['id', 'slug', 'name_'.Yii::$app->language, 'img', 'min_order', 'quantity', 'reserve', 'isset_product_combination', 'category_id'])
            ->where(['id' => $product_ids])
            ->all();

        $product_arr = [];
        $products_category_ids = [];

        foreach ($products as $product) {
            $name = 'name_' . Yii::$app->language;
            $item = [];
            $item['name'] = $product->$name;
            $item['slug'] = $product->slug;
            $item['img'] = $product->img;
            $item['min_order'] = $product->min_order;
            $item['quantity'] = $product->quantity;
            $item['reserve'] = $product->reserve;
            $item['category_id'] = $product->category_id;
            $item['isset_product_combination'] = $product->isset_product_combination;
            $product_arr[$product->id] = $item;

            $products_category_ids[] = $product->category_id;
        }

        $category = Category::find()
            ->select(['id', 'slug'])
            ->where(['id' => $products_category_ids])
            ->asArray()
            ->all();
        $category = ArrayHelper::map($category, 'id', 'slug');

        $products_combination = ProductCombination::find()
            ->select(['id', 'img', 'quantity', 'price', 'reserve', 'parent_id', 'attribute_id', 'attribute_value_id'])
            //->join('LEFT JOIN', 'attribute_list', '`product_combination`.`attribute_id` = `attribute_list`.`id`')
            ->where(['id' => $products_combination_ids])
            ->all();

        $product_combination_arr = [];
        $attributes_value_arr = [];

        if (count($products_combination) > 0) {
            //$attributes_ids = [];
            $attributes_value_ids = [];

            foreach ($products_combination as $one_combination) {
                //$attributes_ids[] = $one_combination->attribute_id;
                $attributes_value_ids[] = $one_combination->attribute_value_id;
                $product_combination_arr[$one_combination->id]['attribute'] = $one_combination->attribute_id;
                $product_combination_arr[$one_combination->id]['attribute_value'] = $one_combination->attribute_value_id;
                $product_combination_arr[$one_combination->id]['price'] = $one_combination->price;
                $product_combination_arr[$one_combination->id]['quantity'] = $one_combination->quantity;
                $product_combination_arr[$one_combination->id]['reserve'] = $one_combination->reserve;
            }

            $attributes_value = AttributeValue::find()
                ->select(['id', 'name_'.Yii::$app->language])
                ->where(['id' => $attributes_value_ids])
                ->all();

            foreach ($attributes_value as $value) {
                $name = 'name_'.Yii::$app->language;
                $attributes_value_arr[$value->id] = $value->$name;
            }
        }

        return $this->render('index', [
            'model' => $model,
            'product_arr' => $product_arr,
            'product_combination_arr' => $product_combination_arr,
            'attributes_value_arr' => $attributes_value_arr,
            'category' => $category,
        ]);
    }

    public function actionAddToCart() {

        if (!Yii::$app->session->get('user_id')) {
            Yii::$app->session->set('user_id', uniqid());
        }

        $id = Yii::$app->request->post('product_id');
        $amount = Yii::$app->request->post('count');
        $product_comb = Yii::$app->request->post('product_comb');

        $curent_product = Product::find()
            ->select(['id', 'price', 'quantity', 'reserve', 'isset_product_combination'])
            ->where(['id' => $id])
            ->one();

        $cart = Cart::findOne(['product_id' => $id, 'product_comb_id' => $product_comb, 'order_id' => 0, 'user_id' => Yii::$app->session->get('user_id')]);

        if (count($cart) == 0) {

            $cart = new Cart();
            $cart->product_id = $id;

            $price = $curent_product->price;

            if ($product_comb == 0) {  // если не передали информацию о наличии комбинации(вида)
                if ($curent_product->isset_product_combination == 1) { // то проверяем существуют ли у продукта комбинации
                    $product_comb_db = ProductCombination::getProductCombinationToProductID($id);
                    if ($product_comb_db == false) {
                        $cart->product_comb_id = 0;
                    } else {
                        $cart->product_comb_id = $product_comb_db->id;
                        $price = $product_comb_db->price;
                    }
                } else {
                    $cart->product_comb_id = 0;
                }
            } else {
                $cart->product_comb_id = $product_comb;
                $product_comb_db = ProductCombination::findOne([
                    'id' => $product_comb,
                    'status' => 1,
                ]);
                $price = $product_comb_db->price;
            }

            $cart->user_id = Yii::$app->session->get('user_id');
            $cart->price = Price::getPrice($price);
            //$cart->price = $price;
            $cart->amount = $amount;
            $cart->date = date('Y-m-d H:i:s');
            $cart->order_id = 0;

        } else {
            $cart->updateCounters(['amount' => $amount]);
        }

        if ( $cart->save() OR count($cart) > 0) {
            $curent_product->updateCounters(['reserve' => $amount]);        // обновляем  резерв продукта
            if ($cart->product_comb_id != 0) {
                $product_comb_db = ProductCombination::findOne([
                    'id' => $cart->product_comb_id,
                    'status' => 1,
                ]);
                if($product_comb_db) {
                    $product_comb_db->updateCounters(['reserve' => $amount]);   // обновляем  резерв вида продукта
                }
            }

            echo json_encode([
                'amount' => $amount,
                'price' => $cart->price,
                //'price' => Price::getPrice($cart->price),
                'mess' => Yii::t('app', 'Product added to cart')
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'mess' => Yii::t('app', 'Error adding product to cart')
            ]);
        }
    }

    public function actionDeleteFromCart () {

        $id = Yii::$app->request->post('id');

        $curent_cart = Cart::findOne($id);

        $product_id = $curent_cart->product_id;
        $product_amount = $curent_cart->amount;
        $product_combination_id = $curent_cart->product_comb_id;

        if ($curent_cart->delete()) {
            $product = Product::findOne(['id' => $product_id]);
            //$reserve = -1 * (int)$amount;
            $product->updateCounters(['reserve' => '-'.$product_amount]);

            if ($product_combination_id != 0) {
                $product_combination = ProductCombination::findOne(['id' => $product_combination_id]);
                $product_combination->updateCounters(['reserve' => '-'.$product_amount]);
            }

            echo json_encode( [
                'product' => $product_id,
                'reserve' => $product_amount,
                'product_combination' => $product_combination_id,
                'mess' => Yii::t('app', 'Product removed from the cart')
            ]);
        }
        else {
            echo json_encode( [
                'status' => false,
                'mess' => Yii::t('app', 'Error to remove the product from the cart')
            ]);
        }
    }

    public function actionUpdateCart() {

        $id = Yii::$app->request->post('id');
        $amount = Yii::$app->request->post('amount');

        $cart_item = Cart::findOne(['id' => $id]);

        $product = Product::findOne(['id' => $cart_item->product_id]);

        $diff = $amount - $cart_item->amount;

        if ($diff != 0) {
            if ($cart_item->updateCounters(['amount' => $diff]) &&
                $product->updateCounters(['reserve' => $diff]) ) {

                $product_combination_id = $cart_item->product_comb_id;
                if ($product_combination_id != 0 ) {
                    $product_combination = ProductCombination::findOne(['id' => $product_combination_id]);
                    $product_combination->updateCounters(['reserve' => $diff]);
                }

                echo json_encode( [
                    'id' => $id,
                    'amount' => $amount,
                    'diff' => $diff,
                    'mess' => Yii::t('app', 'Shopping cart updated'),
                ]);
            } else {
                echo json_encode( [
                    'mess' => Yii::t('app', 'Error to update the cart'),
                    'status' => false
                ]);
            }
        }
        else {
            echo json_encode( [
                'id' => $id,
                'amount' => $amount,
                'diff' => $diff,
                'mess' => Yii::t('app', 'Shopping cart updated'),
            ]);
        }



    }

}
