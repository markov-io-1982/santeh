<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\models\Cart;
use backend\models\Order;
use backend\models\OrderSearch;
use backend\models\OrderStatus;
use backend\models\Product;
use backend\models\ProductDetail;
use backend\models\ProductCombination;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
        $searchModel = new OrderSearch(['type' => 0]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** новые заказы */
    public function actionNew()
    {
        $searchModel = new OrderSearch(['type' => 0, 'order_status_id' => 2]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider = $searchModel->search(['order_status_id' => 2]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** заказы в 1 клик */
    public function actionClick()
    {
        $searchModel = new OrderSearch(['type' => 1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** новые заказы в 1 клик */
    public function actionNewClick()
    {
        $searchModel = new OrderSearch(['type' => 1, 'order_status_id' => 2]);
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $prev_order_status = $model->order_status_id;

        $mes = $prev_order_status;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ( $model->save() ) {

                if (OrderStatus::changeStatus($prev_order_status, $model->order_status_id) == true) {

                    $mes = 'if';

                    $cart_items = Cart::find()
                        ->select(['product_id', 'product_comb_id', 'amount'])
                        ->where(['order_id' => $model->id])
                        ->all();

                    // обновляем счетчики количества товаров, резерва и купленых
                    foreach ($cart_items as $item) {
                        $product = Product::find()
                            ->select(['id', 'reserve', 'quantity'])
                            ->where(['id' => $item->product_id])
                            ->one();
                        $product->updateCounters(['reserve' => '-'.$item->amount]);
                        $product->updateCounters(['quantity' => '-'.$item->amount]);

                        $product_detail = ProductDetail::find()
                            ->where(['product_id' => $item->product_id])
                            ->one();
                        $product_detail->updateCounters(['buy' => $item->amount]);

                        $mes .= $product_detail->id."-";

                        if ($item->product_comb_id != 0) {
                            $product_combination = ProductCombination::find()
                                ->select(['id', 'reserve', 'quantity', 'buy'])
                                ->where(['id' => $item->product_comb_id])
                                ->one();
                            $product_combination->updateCounters(['reserve' => '-'.$item->amount]);
                            $product_combination->updateCounters(['quantity' => '-'.$item->amount]);
                            $product_combination->updateCounters(['buy' => $item->amount]);
                        }
                    }

                }
            }

            return $this->redirect(['view', 'id' => $model->id, 'mes' => $mes]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
