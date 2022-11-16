<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\models\Price;

use backend\models\OrderStatus;

use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderSearch;
use frontend\models\Product;
use frontend\models\ProductCombination;
use frontend\models\S;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Page no found'));
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        $data = [];

        $cart_items = Cart::find()
            ->where(['user_id' => Yii::$app->session->get('user_id'), 'order_id' => 0])
            ->all();

        $total_amount = 0;
        $total_sum = 0;
        foreach ($cart_items as $item) {
            //$total_sum += Price::getPrice($item->price) * $item->amount;
            $total_sum += $item->price * $item->amount;
            $total_amount += $item->amount;
        }
        //$price_all = ArrayHelper::getColumn($cart_items, 'price');
        //$amount_all = ArrayHelper::getColumn($cart_items, 'amount');
        //$data['total_amount'] = array_sum($amount_all);
        //$model->total_sum = Price::getPrice(array_sum($price_all)) * $data['total_amount'];

        $data['total_amount'] = $total_amount;
        $model->total_sum = $total_sum;
        $model->type = 0;
        $model->order_status_id = OrderStatus::getStatusNew();  // ! устанавливается статус новый с ID 2

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {

            $model->date_create = date('Y-m-d H:i:s');
            $model->user_comment .= ' Валюта: ' . Yii::$app->getRequest()->getCookies()->getValue('curr');

            if ( $model->save() ) {
                foreach ($cart_items as $item) {
                    $item->updateCounters(['order_id' => $model->id]);
                }

                $send_from = S::getCont('admin_mail');
                $send_to = S::getCont('order_mails');
                $send_to = explode(",", $send_to);

                Yii::$app->mailer->compose()
                    ->setFrom($send_from)
                    ->setTo($send_to)
                    ->setSubject('Новый заказ #'. $model->code)
                    //->setTextBody('Текст сообщения')
                    ->setHtmlBody('<p>На сайте оформлен новый заказ # '.$model->code.'<br>Сумма: '.$model->total_sum.'</p>')
                    ->send();

            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'data' => $data
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {

    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /** купить в один клик */
    public function actionBuyOneClick() {

        $order = new Order();
        $cart = new Cart();

        $id = Yii::$app->request->post('id');
        $amount = Yii::$app->request->post('amount');
        $product_comb_id = Yii::$app->request->post('product_comb_id');
        $user_id = (!Yii::$app->session->get('user_id')) ? 0 : Yii::$app->session->get('user_id');
        $user_phone = Yii::$app->request->post('user_phone');
        $user_email = Yii::$app->request->post('user_email');

        $last_order = Order::find()->orderBy('id DESC')->one();
        $product = Product::findOne(['id' => $id]);

        $price = $product->price;

        if ($product_comb_id != 0) {
            $product_combination = ProductCombination::findOne(['id' => $product_comb_id]);
            $price = $product_combination->price;
        }

        $order->id = intval($last_order->id) + 1;
        $order->code = $order->id . '-' . date('Ymd');
        $order->user_id = $user_id;
        $order->delivery_method_id = 0;
        $order->payment_metod_id = 0;

        $order->user_name = ' ';
        //$order->user_middlename =
        $order->user_lastname = '';
        $order->user_email = $user_email;
        $order->user_phone = $user_phone;
        $order->user_adress = ' ';

        $order->user_comment = 'Валюта: ' . Yii::$app->getRequest()->getCookies()->getValue('curr');

        $order->total_sum = $amount * Price::getPrice($price);
        //$order->total_sum = $amount * $price;

        $order->order_status_id = 2; // устанавливаем статус "Новый"
        $order->type = 1; // устанавливаем тип "Покупка в один клик"
        $order->date_create = date('Y-m-d H:i:s');

        $cart->product_id = $id;
        $cart->product_comb_id = $product_comb_id;
        $cart->user_id = $user_id;
        $cart->amount = $amount;
        $cart->price = Price::getPrice($price);
        //$cart->price = $price;
        $cart->date = date('Y-m-d H:i:s');
        $cart->order_id = $order->id;

        if ( $order->save(false)
             && $cart->save(false)
             ) {
            $product->updateCounters(['reserve' => $amount]);
            if ($product_combination) {
                $product_combination->updateCounters(['reserve' => $amount]);
            }

            echo json_encode([
                'id' => $id,
                'product_comb_id' => $product_comb_id,
                'amount' => $amount,
                'user_id' => $user_id,
                'user_phone' => $user_phone,
                'user_email' => $user_email,
                'price' => $order->total_sum,
                'mess' => Yii::t('app', 'Спасибо за заказ. Наш админиcтратор свяжется с Вами.')
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'mess' => Yii::t('app', 'Произошла ошибка')
            ]);
        }



    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Page no found'));
        }
    }

}
