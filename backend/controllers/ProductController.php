<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductDetail;
use backend\models\ProductCombination;
use backend\models\ProductImages;
use backend\models\RelationsProductProduct;
use backend\models\RelationsProductAtribute;
use backend\models\ImportXls;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\User;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    public function beforeAction($action)
    { // отключает проверку csrf
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'get-product-by-catrgory', 'import-xls'],
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $product_detail = ProductDetail::findOne(['product_id' => $id]);
        $product_combination = ProductCombination::getCombination($id);
        $product_images = ProductImages::find()
            ->where(['product_id' => $id])
            ->orderBy('sort_position ASC')
            ->all();
        $relations_product = RelationsProductProduct::getReationsProduct($id);
        $relations_attributes = RelationsProductAtribute::getReationsAtribute($id);

        return $this->render('view', [
            'model' => $model,
            'product_detail' => $product_detail,
            'product_combination' => $product_combination,
            'product_images' => $product_images,
            'relations_product' => $relations_product,
            'relations_attributes' => $relations_attributes

        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $product_detail = new ProductDetail();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $seo_title = 'seo_title_' . Yii::$app->language;
            $name = 'name_' . Yii::$app->language;
            $product_detail->$seo_title = $model->$name;
            $model->getTime();

            if ($_FILES['Product']['name']['fileimg'] != '') { // Check if exist (not empty) value for images
                $model->uploadFile();                           // Uploaded file in the server
            } else {
                //$model['img'] = '';
                $model['img'] = 'images/default_product.png';
            }
            if ($model->save()) {

                $product_detail->product_id = $model->id;

                if ($product_detail->save()) {
                    $name = 'name_' . Yii::$app->language;
                    Yii::$app->session->setFlash(
                        'success',
                        Yii::t('app', 'Product') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully created')
                    );
                } else {
                    return $this->redirect(['delete', 'id' => $model->id]);
                    Yii::$app->session->setFlash(
                        'danger',
                        Yii::t('app', 'Error')
                    );
                }

                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t('app', 'Error')
                    //. ' '. print_r($model->errors,true)
                );

                return $this->render('create', [
                    'model' => $model,
                    //'product_detail' => $product_detail
                ]);
            }


        } else {
            return $this->render('create', [
                'model' => $model,
                //'product_detail' => $product_detail
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $product_detail = ProductDetail::find()->where(['product_id' => $id])->one();

        $model->setTime();                                                      // помещаем данные с поля promo_date_end
        // базы данных в поля время и даты
        if ($model->load(Yii::$app->request->post()) &&
            $model->validate() &&
            $product_detail->load(Yii::$app->request->post()) &&
            $product_detail->validate()
        ) {

            $model->getTime();                                                  // складываем дату и время в одну строку

            if ($_FILES['Product']['name']['fileimg'] != '') {                  // проверяем есть ли нововое изображени
                if ($model->img != '') {                                        // проверяем хранится ли в базе данных запись с изображением
                    if (file_exists('../../frontend/web/' . $model->img)) {   // проверяем существует ли старое изображение
                        unlink('../../frontend/web/' . $model->img);            // удаляем изображение
                    }
                }
                $model->uploadFile();                                           // загружаем новое изображение
            }

            if ($model->isset_product_combination == 1) {
                $model->quantity = 1;

                $product_combinations = ProductCombination::find()
                    ->select(['id', 'quantity'])
                    ->where(['parent_id' => $model->id])
                    ->all();

                if (count($product_combinations) == 0) {
                    $model->quantity = 2;
                } else {
                    $quantity = ArrayHelper::getColumn($product_combinations, 'quantity'); // получаем массив с количеством
                    $model->quantity = array_sum($quantity);                // сумируем количество
                }
            }

            if ($model->save()) {
                if ($product_detail->save()) {
                    $name = 'name_' . Yii::$app->language;
                    Yii::$app->session->setFlash(
                        'success',
                        Yii::t('app', 'Product') . ' ' . $model->$name . ' ' . Yii::t('app', 'successfully updated')
                    );
                } else {
                    Yii::$app->session->setFlash(
                        'danger',
                        Yii::t('app', 'When you save an error occurred')
                    );
                }

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
                'product_detail' => $product_detail
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $product = $this->findModel($id);
        $product_detail = ProductDetail::find()->where(['product_id' => $id])->one();

        $name = 'name_' . Yii::$app->language;
        $name = $product->$name;

        if ($product->img != '') {                                              // проверяем не пуста ли запись о изображении
            if (file_exists('../../frontend/web/' . $product->img)) {         // если файл существует
                unlink('../../frontend/web/' . $product->img);                  // удаляем файл
            }
        }

        if ($product->delete() && $product_detail->delete()) {

            // удаляем комбинации продукта
            $combination_ids = ProductCombination::find()->select(['id'])->where(['parent_id' => $id])->all();
            $count_combination = 0;
            foreach ($combination_ids as $comb_id) {
                $combination = ProductCombination::find()->where(['id' => $comb_id])->one();
                if ($combination->img != '') {                                              // проверяем не пуста ли запись о изображении
                    if (file_exists('../../frontend/web/' . $combination->img)) {         // если файл существует
                        unlink('../../frontend/web/' . $combination->img);                  // удаляем файл
                    }
                }
                if ($combination->delete()) {
                    $count_combination++;
                }

            }

            // удаляем изображения
            $img_ids = ProductImages::find()->select(['id'])->where(['product_id' => $id])->all();
            $count_imgs = 0;
            foreach ($img_ids as $img_id) {
                $img = ProductImages::find()->where(['id' => $img_id])->one();
                if (file_exists('../../frontend/web/' . $img->url)) {         // если файл существует
                    unlink('../../frontend/web/' . $img->url);                  // удаляем файл
                }
                if ($img->delete()) {
                    $count_imgs++;
                }
            }

            // удаляем связанные атрибуты
            $attr_ids = RelationsProductAtribute::find()->select(['id'])->where(['product_id' => $id])->all();
            $count_attr = 0;
            foreach ($attr_ids as $attr_id) {
                $attr = RelationsProductAtribute::find()->where(['id' => $attr_id])->one();
                if ($attr->delete()) {
                    $count_attr++;
                }
            }

            // удаляем связи с другими продуктами
            $product_rel_ids = RelationsProductProduct::find()->select(['id'])->where(['product_main_id' => $id])->all();
            $count_product_rel = 0;
            foreach ($product_rel_ids as $p_rel_id) {
                $prod_rel = RelationsProductProduct::find()->where(['id' => $p_rel_id])->one();
                if ($prod_rel->delete()) {
                    $count_product_rel++;
                }
            }

            // удаляем коментарии к данному продукту
            $review_ids = \backend\models\Review::find()->select(['id'])->where(['product_id' => $id])->all();
            $count_review = 0;
            foreach ($review_ids as $rev_id) {
                $review = \backend\models\Review::find()->where(['id' => $rev_id])->one();
                if ($review->delete()) {
                    $count_review++;
                }
            }


            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'Product') . ' ' . $name . ' ' . Yii::t('app', 'successfully deleted')
                . '<br>Также удалены связанные с ним:'
                . '<br>комбинации (виды) продукта - ' . $count_combination
                . '<br>изображения - ' . $count_imgs
                . '<br>атрибуты - ' . $count_attr
                . '<br>связи с продуктамы - ' . $count_product_rel
                . '<br>коментарии - ' . $count_review
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetProductByCatrgory($id)
    {
        $countProducts = Product::find()
            ->where(['category_id' => $id])
            ->count();

        $products = Product::find()
            ->where(['category_id' => $id])
            ->orderBy('sort_position DESC')
            ->all();

        if ($countProducts > 0) {
            foreach ($products as $product) {
                $name = 'name_' . Yii::$app->language;
                echo "<option value='" . $product->id . "'>" . $product->$name . "</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }


    /**
     * Import excel.
     * @return mixed
     */
    public function actionImportXls()
    {
        $model = new ImportXls();
        $result = null;

        //if(Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())
            && $model->validate()
        ) {
            $result = Product::importXls($model);
        }

        return $this->render('import-xls', [
            'model' => $model,
            'result' => $result,
        ]);
    }
}
