<?php

namespace backend\controllers;

use Yii;
use backend\models\Slideshow;
use backend\models\SlideshowSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/**
 * SlideshowController implements the CRUD actions for Slideshow model.
 */
class SlideshowController extends Controller
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
     * Lists all Slideshow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SlideshowSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slideshow model.
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
     * Creates a new Slideshow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slideshow();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($_FILES) {
                if ($_FILES['Slideshow']['name']['fileimg'] != '') { // если есть загруженное изображение 
                    $model->uploadFile();   // загружаем изображение на сервер                
                }else {
                    $model['img'] = '';
                }
            } else {
               $model['img'] = ''; 
            }

            if ($model->save()) {
                $name = 'name_' . Yii::$app->language;
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Slide') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully created')
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
     * Updates an existing Slideshow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($_FILES['Slideshow']['name']['fileimg'] != '') {                  // проверяем есть ли нововое изображени
                if ($model->img != '') {                                        // проверяем хранится ли в базе данных запись с изображением
                    if( file_exists ('../../frontend/web/' . $model->img) ) {   // проверяем существует ли старое изображение
                        unlink('../../frontend/web/' . $model->img);            // удаляем изображение
                    }                    
                }
                $model->uploadFile();                                           // загружаем новое изображение
            }

            if ($model->save()) {
                $name = 'name_' . Yii::$app->language;
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Slide') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully updated')
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
     * Deletes an existing Slideshow model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $slide = $this->findModel($id);
        $name = 'name_' . Yii::$app->language;
        $name = $slide->$name;

        if ($slide->img != '') {                                              // проверяем не пуста ли запись о изображении
            if( file_exists ('../../frontend/web/' . $slide->img) ) {         // если файл существует
                unlink('../../frontend/web/' . $slide->img);                  // удаляем файл
            }
        }  

        if ($slide->delete()) {
            Yii::$app->session->setFlash(
                'success', 
                Yii::t('app', 'Slide') . ' ' . $name . ' ' . Yii::t('app', 'successfully deleted')
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
     * Finds the Slideshow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slideshow the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slideshow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
