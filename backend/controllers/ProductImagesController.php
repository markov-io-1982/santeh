<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductImages;
use backend\models\ProductImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\User;

/**
 * ProductImagesController implements the CRUD actions for ProductImages model.
 */
class ProductImagesController extends Controller
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
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'language'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           return User::isUserAdmin(Yii::$app->user->identity->username);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductImages model.
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
     * Creates a new ProductImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductImages();
        $model->product_id = $_GET['product_id'];

        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ( $_FILES && $model->load(Yii::$app->request->post()) ) {

            if ($_FILES['ProductImages']['name']['fileimg'] != '') { // если есть загруженное изображение 
               $model->uploadFile();                           // загружаем изображение на сервер
            } else {
                $model['url'] = '';                            
            }

            if ($model->save()) {
                echo true;
            }

            // return $this->redirect(['product/update', 'id' => $_GET['product_id'], '#' => 'imgs']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $img = $this->findModel($id);

        if ($img->url != '') {                                              // проверяем не пуста ли запись о изображении
            if( file_exists ('../../frontend/web/' . $img->url) ) {         // если файл существует
                unlink('../../frontend/web/' . $img->url);                  // удаляем файл
            }
        }  

        if ($img->delete()) {
            echo true;
            // Yii::$app->session->setFlash(
            //     'success', 
            //     Yii::t('app', 'Product') . ' ' . $name . ' ' . Yii::t('app', 'successfully deleted')
            // );
        }
        else {
            echo 'Error';
        }

        //return $this->redirect(['index']);
    }

    /**
     * Finds the ProductImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
