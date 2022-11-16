<?php

namespace backend\controllers;

use yii\helpers\Url;
use Yii;
use backend\models\Category;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/** @noinspection PhpUndefinedClassInspection */

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    public function beforeAction($action)
    { // отключает проверку csrf
        $this->enableCsrfValidation = false;
        /** @noinspection PhpUndefinedClassInspection */
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'build'],
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
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $name = 'name_' . Yii::$app->language;
            if ($_FILES['Category']['name']['fileimg'] != '') { // Check if exist (not empty) value for images
                $model->uploadFile(); // Uploaded file in the server
            } else {
                $model['img'] = '';
            }
            if ($model->save()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Category') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully created')
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
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $name = 'name_' . Yii::$app->language;
            $urlImg = $model->img;
            if ($_FILES['Category']['name']['fileimg'] != '') { // Check if exist (not empty) value for images
                $model->uploadFile(); // Uploaded file in the server
                @unlink("../../frontend/web/" . $urlImg); // Drop image
            } else {
                $model['img'] = $urlImg;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Category') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully updated')
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
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $category = $this->findModel($id);
        $name = 'name_' . Yii::$app->language;
        $name = $category->$name;
        if ($category->delete()) {
            @unlink("../../frontend/web/" . $category->img);// Drop image
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Category') . ' ' . $name . ' ' . Yii::t('app', 'successfully deleted')
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
