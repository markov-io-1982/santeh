<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductCombination;
use backend\models\ProductCombinationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/**
 * ProductCombinationController implements the CRUD actions for ProductCombination model.
 */
class ProductCombinationController extends Controller
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
     * Lists all ProductCombination models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCombinationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCombination model.
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
     * Creates a new ProductCombination model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductCombination();
		$model->parent_id = $_GET['product_id'];
		//$model->img = '';

        //if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ( $model->load(Yii::$app->request->post()) ) {

			if ($_FILES) {
				if ( $_FILES['ProductCombination']['name']['fileimg'] != '' ) { // если есть загруженное изображение
				   $model->uploadFile(); // загружаем изображение на сервер
				} else {
                    //$model->img = '';
                    $model->img = 'images/default_product.png';
                }
            } else {
				//$model->img = '';
                $model->img = 'images/default_product.png';
			}


            if ( $model->save() ) {
                //echo($model);
                echo true;
            }
            else {
                echo "Error";
            }

            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductCombination model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( $model->load(Yii::$app->request->post() ) ) {

			if ($_FILES) {
				if ($_FILES['ProductCombination']['name']['fileimg'] != '') { // если есть загруженное изображение
                    if( file_exists ('../../frontend/web/' . $model->img) ) {         // если файл существует
                        unlink('../../frontend/web/' . $model->img);                  // удаляем файл
                    }
				   $model->uploadFile();                           // загружаем изображение на сервер
				}
			}
            // else {
            //     $model->uploadFile();
            // }

            if ($model->save()) {
                echo true;
            }
			else {
				echo 'Error';
			}

            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Deletes an existing ProductCombination model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $combination = $this->findModel($id);

        if ($combination->img != '') {                                              // проверяем не пуста ли запись о изображении
            if( file_exists ('../../frontend/web/' . $combination->img) ) {         // если файл существует
                unlink('../../frontend/web/' . $combination->img);                  // удаляем файл
            }
        }

        if ($combination->delete()) {
            echo true;
        }
        else {
            echo 'Error';
        }

//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductCombination model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCombination the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCombination::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
