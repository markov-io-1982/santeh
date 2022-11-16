<?php

namespace backend\controllers;

use Yii;
use backend\models\AttributeValue;
use backend\models\AttributeValueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

/**
 * AttributeValueController implements the CRUD actions for AttributeValue model.
 */
class AttributeValueController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'values'],
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
     * Lists all AttributeValue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttributeValueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AttributeValue model.
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
     * Creates a new AttributeValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AttributeValue();

        if (isset($_GET['attr'])) {
            $model->attribute_id = $_GET['attr'];
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model['no_image'] == 1) {
                $model['img'] = '';
            } else {
                if ($_FILES['AttributeValue']['name']['fileimg'] != '') { // если есть загруженное изображение 
                    $model->uploadFile();   // загружаем изображение на сервер
                } else {
                    $model['img'] = '';
                }                      
            }

            if ($model->save()) {
                $name = 'name_' . Yii::$app->language;
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Value of attribute') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully created')
                );                
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Error')
                );                 
            }

            if (isset($_GET['attr'])) {
                return $this->redirect(['/attribute-list/index']);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AttributeValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->no_image != 1) {
                if ($_FILES['AttributeValue']['name']['fileimg'] != '') {                  // проверяем есть ли нововое изображени
                    if ($model->img != '') {                                        // проверяем хранится ли в базе данных запись с изображением
                        if( file_exists ('../../frontend/web/' . $model->img) ) {   // проверяем существует ли старое изображение
                            unlink('../../frontend/web/' . $model->img);            // удаляем изображение
                        }                    
                    }
                    $model->uploadFile();                                           // загружаем новое изображение
                }
            } else {
                $model['img'] = '';
            }

            if ($model->save()) {
                $name = 'name_' . Yii::$app->language;
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'Value of attribute') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully updated')
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
     * Deletes an existing AttributeValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $attribute_value = $this->findModel($id);
        $name = 'name_' . Yii::$app->language;
        $name = $attribute_value->$name;

        if ($attribute_value->img != '') {                                              // проверяем не пуста ли запись о изображении
            if( file_exists ('../../frontend/web/' . $attribute_value->img) ) {         // если файл существует
                unlink('../../frontend/web/' . $attribute_value->img);                  // удаляем файл
            }
        }  

        if ($attribute_value->delete()) {
            Yii::$app->session->setFlash(
                'success', 
                Yii::t('app', 'Value of attribute') . ' ' . $name . ' ' . Yii::t('app', 'successfully deleted')
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
     * Finds the AttributeValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AttributeValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AttributeValue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function actionValues ($id_attr) {
        $countValues = \backend\models\AttributeValue::find()
                ->where(['attribute_id' => $id_attr])
                ->count();
 
        $values = \backend\models\AttributeValue::find()
                ->where(['attribute_id' => $id_attr])
                ->orderBy('sort_position DESC')
                ->all();
 
        if ($countValues> 0 ) {
            foreach($values as $val){
				$name = 'name_' . Yii::$app->language;
                echo "<option value='".$val->id."'>".$val->$name."</option>";
            }
        }
        else{
            echo "<option>-</option>";
        }		
	}
	
}
