<?php

namespace backend\controllers;

use Yii;
use backend\models\StockStatus;
use backend\models\StockStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/**
 * StockStatusController implements the CRUD actions for StockStatus model.
 */
class StockStatusController extends Controller
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
     * Lists all StockStatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StockStatus model.
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
     * Creates a new StockStatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StockStatus();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save()) {
                $name = 'name_' . Yii::$app->language;
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Stock status') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully created')
                );                
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Error')
                );                 
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StockStatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save()) {
                $name = 'name_' . Yii::$app->language;
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Stock status') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully updated')
                );
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Error')
                );      
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StockStatus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $stock_status = $this->findModel($id);
        $name = 'name_' . Yii::$app->language;
        $name = $stock_status->$name;

        if ($stock_status->delete()) {
            Yii::$app->session->setFlash(
                'success', 
                Yii::t('app', 'Stock status') . ' ' . $name . ' ' . Yii::t('app', 'successfully deleted')
            );
        } else {
            Yii::$app->session->setFlash(
                'danger',
                Yii::t('app', 'Error')
            );             
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the StockStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockStatus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
