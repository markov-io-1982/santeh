<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use common\models\PaymentWm;
use frontend\models\Order;
use frontend\models\PaymentPb;
use frontend\models\S;

/**
 * Shop controller
 */
class PaymentController extends Controller
{

    public function beforeAction($action) { // отключает проверку csrf
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
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
        return $this->render('index', [

        ]);
    }

    public function actionWmpayform($id)
    {
        $order = Order::findOne(["id" => $id]);
        $wm_payment = PaymentWm::findOne(["order_id" => $id]);

        if (!empty($wm_payment) && $wm_payment->status == 1) {
            $status = 1;        
        }

        else {
            Yii::$app->session->set('current_order', $order->id);
            $wm_payment = New PaymentWm;
            $wm_payment->order_id = $order->id;
            $wm_payment->user_id = Yii::$app->session->get('user_id');
            $wm_payment->amt = $order->total_sum;
            $wm_payment->date_create = date('Y-m-d H:i:s');
            $wm_payment->phone = $order->user_phone;
            $wm_payment->details = 'Заказ: ' . $order->code . ',<br />Телефон: ' . $order->user_phone . ',<br />Email: ' . $order->user_email . ',<br />Имя: ' . $order->user_name;
            $wm_payment->status = 0;
            $wm_payment->note = 'Совершенние оплаты началось';
            $wm_payment->save();
            $status = 0;        
        }


        return $this->render ( 'wmpayform', [
            'order' => $order,
            'wm_payment' => $wm_payment,
            'status' => $status,
        ]);         
    }

    public function actionWmpay () {
        return $this->renderAjax ('wmpay');
    }

    public function actionWmsuccess () {
        //$_SESSION['current_order'];

        if ( Yii::$app->session->get('current_order') != '' ) {
            $model = \frontend\models\Order::findOne(["id" => Yii::$app->session->get('current_order')]);
            
            $model->order_status_id = 3;                    // статус "Оплачено (не отправлено)"
            $model->date_payment = date ( "Y-m-d H:i:s" );  // дата оплаты

            $model->save();
            Yii::$app->session->set('current_order', '');

            return $this->render ( 'wmsuccess', [
                'model' => $model,
            ]);         
        }
        else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Page no found'));
        }
    }

    public function actionWmfail () {

        if (  Yii::$app->session->get('current_order') == '' ) {
            $model = \frontend\models\Order::findOne(["id" =>Yii::$app->session->get('current_order')]);

            return $this->render ( 'wmfail', [
                'model' => $model,
            ]); 
        }
        else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Page no found'));
        }
    
    }

    public function actionPbPaidForm($id)
    {
        $order = Order::findOne(['id' => $id]);
        $payment_pb = new PaymentPb();
        $payment_pb->amt = $order->total_sum;
        $payment_pb->order_id = $id;
        $payment_pb->note = "Совершение оплаты началось";
        $payment_pb->pay_status = 0;
        $payment_pb->ext_details = 'Оплата заказа #' . $order->code . ' на сумму ' . $order->total_sum;
        $payment_pb->details = "Оплата заказа #" . $order->code;
        $payment_pb->date_create = date('Y-m-d H:i:s');
        $payment_pb->save(false);

        Yii::$app->session->set('current_order', $id);

        return $this->render('pb-paid-form', [
            'order' => $order
        ]);
    }

    public function actionPbAfterPaid($id)
    {

        //$id = Yii::$app->session->get('current_order');

        $order = Order::findOne(['id' => $id]);
        $payment_pb = PaymentPb::findOne(['order_id' => $id]);

        $merchant_password = S::getCont('pb_merchant_password');

        $posted = $_POST['payment'];
        $hash = sha1(md5($posted.$merchant_password));
        if (isset($_POST['payment']) && $hash == $_POST['signature']){
            $items = explode("&", $_POST['payment']);
            $ar = array();

            foreach($items as $it){
                $key = "";
                $value = "";
                list($key, $value) = explode("=", $it, 2);
                $payment_items[$key] = $value;
            }

            $payment_pb->amt_total = $payment_items['amt'];
            $payment_pb->ccy = $payment_items['ccy'];
            $payment_pb->merchant = $payment_items['merchant'];
            $payment_pb->pay_way = $payment_items['pay_way'];
            $payment_pb->state = $payment_items['state'];
            $payment_pb->ref = $payment_items['ref'];
            $payment_pb->sender_phone = $payment_items['sender_phone'];
            $payment_pb->pay_status = 1;
            $payment_pb->date_update = date('Y-m-d H:i:s');
            $payment_pb->note = "Оплата прошла успешно";
            $payment_pb->save(false);

            $order->order_status_id = 3;            // Оплачено (не отправлено)
            $order->date_payment = date('Y-m-d H:i:s');
            $order->save(false);

            Yii::$app->session->set('current_order', '');

            //var_dump($payment_items);

            return $this->render ('pb-after-paid', [
                'order' => $order
            ]);
        }else{
            $payment_pb->pay_status = 0;
            $payment_pb->date_update = date('Y-m-d H:i:s');
            $payment_pb->note = "Ошибка вовремя оплаты";
            $payment_pb->save(false);
            return $this->render ('pb-fail', [
                'order' => $order
            ]);
        }


        
    }

    public function actionPbPaid()
    {

        $id = Yii::$app->session->get('current_order');

        $order = Order::findOne(['id' => $id]);
        $payment_pb = PaymentPb::findOne(['order_id' => $id]);

        $merchant_password = S::getCont('pb_merchant_password');

        $posted = $_POST['payment'];
        $hash = sha1(md5($posted.$merchant_password));
        if (isset($_POST['payment']) && $hash === $_POST['signature']){
            $items = explode("&", $_POST['payment']);
            $ar = array();

            foreach($items as $it){
                $key = "";
                $value = "";
                list($key, $value) = explode("=", $it, 2);
                $payment_items[$key] = $value;
            }

            $payment_pb->amt_total = $payment_items['amt'];
            $payment_pb->ccy = $payment_items['ccy'];
            $payment_pb->merchant = $payment_items['merchant'];
            $payment_pb->pay_way = $payment_items['pay_way'];
            $payment_pb->state = $payment_items['state'];
            $payment_pb->ref = $payment_items['ref'];
            $payment_pb->sender_phone = $payment_items['sender_phone'];
            $payment_pb->pay_status = 1;
            $payment_pb->date_update = date('Y-m-d H:i:s');
            $payment_pb->note = "Оплата прошла успешно";
            $payment_pb->save(false);

            $order->order_status_id = 3;            // Оплачено (не отправлено)
            $order->date_payment = date('Y-m-d H:i:s');
            $order->save(false);

            Yii::$app->session->set('current_order', '');

            //var_dump($payment_items);

            return $this->renderAjax ('pb-paid');
        }else{
            $payment_pb->pay_status = 1;
            $payment_pb->date_update = date('Y-m-d H:i:s');
            $payment_pb->note = "Оплата прошла успешно";
            $payment_pb->save(false);
            return $this->render ('pb-fail', [
                'order' => $order
            ]);
        }

        
    }


}