<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

use frontend\models\Category;
use frontend\models\Product;
use frontend\models\ProductDetail;
use frontend\models\AttributeList;
use frontend\models\AttributeValue;
use frontend\models\RelationsProductAtribute;
use frontend\models\ProductImages;
use frontend\models\ProductCombination;
use frontend\models\Review;

/**
 * Shop controller
 */
class ShopController extends Controller
{
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
        return $this->render('index');
    }

    public function actionSearch()
    {
            $param_where = [];
            $sort = '';

            $q = Yii::$app->request->get('q');

            if ( isset($_GET['sort']) ) { // проверяем  наличие критерия для сортировки
                $sort = Product::getSortBy($_GET['sort']);
            }

            $product_detail = ProductDetail::find()
                ->select(['product_id'])
                ->where(
                    ['like', 'description_'.Yii::$app->language, $q]
                )
                ->all();

            $product_ids = ArrayHelper::getColumn($product_detail, 'product_id');

            $param_where['status'] = 1;

            $query = Product::find()
                ->select('*')
                ->where($param_where)
                //->andFilterWhere(['or', ['id'=> $_GET['category']], ['slug'=> $_GET['category']]])
                ->orderBy($sort);

                $query->andFilterWhere([
                    'or',
                    ['like', 'name_'.Yii::$app->language, $q],
                    ['id' => $product_ids]
                ]);

            $countQuery = clone $query;
            $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
            $products = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            $category_slugs = Category::find()
                ->select(['id', 'slug'])
                ->all();
            $category_slugs = ArrayHelper::map($category_slugs, 'id', 'slug');

            return $this->render('search', [
                'q' => Yii::$app->request->get('q'),
                'count_product' => $countQuery->count(),
                'category_slugs' => $category_slugs,
                'products' => $products,
                'pages' => $pages,
            ]);
    }

    public function actionAutocomplete()
    {
        $term = Yii::$app->request->get('term');

        $products_title = Product::find()
            ->select(['name_'.Yii::$app->language])
            ->where(
                ['like', 'name_'.Yii::$app->language, $term]
            )
            ->all();

        if (count($products_title > 0)) {
            $array_resp = ArrayHelper::getColumn($products_title, 'name_'.Yii::$app->language);
            echo json_encode($array_resp);
        } else {
             echo json_encode([]);
        }
    }

    public function actionProducts()
    {
        if (isset($_GET['category']) && isset($_GET['id'])) {

            $product_id = $_GET['id'];
            $category_id = $_GET['category'];

            if (is_numeric($product_id)) {     /* проверяем является ли продукт числом*/
                $product = Product::findOne($product_id);
                if (count($product) <= 0) {
                    throw new NotFoundHttpException(Yii::t('app', 'Page no found'));
                }
            } else {
                $product = Product::findOne(['slug' => $product_id]);
                if (count($product) <= 0) {
                    throw new NotFoundHttpException(Yii::t('app', 'Page no found'));
                }
            }

            // получаем текущую категорию
            $cur_category = Category::find()
                ->where(['or', ['id'=> $category_id], ['slug'=> $category_id]])
                ->one();
                if (count($cur_category) <= 0) {
                    throw new NotFoundHttpException(Yii::t('app', 'Page no found'));
                }

            // получаем данные с таблицы "product_detail" для текущего продукта
            $product_detail = ProductDetail::findOne(['product_id' => $product->id]);
            $product_detail->updateCounters(['count_views' => 1]);

            // изображения для текущего продукта
            $images = ProductImages::find()
                ->select(['url', 'sort_position'])
                ->where(['product_id' => $product->id])
                ->orderBy('sort_position')
                ->all();

            $product_combinations = ProductCombination::getProductCombinationArrayToProductID($product->id);

            $product_attributes = RelationsProductAtribute::getAttributesList($product->id);

            $related_products = Product::getAllReationsProduct($product->id);

            //var_dump($rows);

	        return $this->render('product', [
	            'id' => $product_id,
	            'category' => $cur_category,
                'product' => $product,
                'product_detail' => $product_detail,
                'images' => $images,
                'product_combinations' => $product_combinations,
                'product_attributes' => $product_attributes,
                'related_products' => $related_products,
	        ]);

/* перейти в категорию */
        } else if ( isset($_GET['category']) ) {

            $category_id = $_GET['category'];

            $where_filter_brand = [];

            /* проверяем является ли категория числом, если нет, то получаем ID категории по Slug для выборки продутов */
            if (!is_numeric($category_id)) {
                $cur_category = Category::find()->where(['slug' => $category_id])->one();
                if (count($cur_category) <= 0) {
                   throw new NotFoundHttpException(Yii::t('app', 'Page no found'));
                }
                $category_id = $cur_category->id;
            } else {
                $cur_category = Category::find()->where(['id' => $category_id])->one();
                if (count($cur_category) <= 0) {
                    throw new NotFoundHttpException(Yii::t('app', 'Page no found'));
                }
            }

            if (count($cur_category) <= 0) {
                throw new NotFoundHttpException(Yii::t('app', 'Page no found'));
            }

            // отбираем дочерние категории
            $child_category = Category::find()
                ->select([])
                ->where(['status' => 1, 'parent_id' => $cur_category->id])
                ->all();
            //var_dump($child_category);

            // если есть дочерние категории
            if (count($child_category) > 0) {
                //var_dump($category_id);
                return $this->render('catrgory-catalog', [
                    'cur_category' => $cur_category,
                    'category' => $category_id,
                    'child_category' => $child_category
                ]);
            }

            $where_filter_brand[] = $category_id;

            $cat = $cur_category;
            while (true) {
                if($cat->parent_id != 0) {
                    $where_filter_brand[] = $cat->id;
                    $temp_cat = Category::findOne(['id' => $cat->parent_id]);
                    $cat = $temp_cat;
                } else {
                    break;
                }
            }

            $where_filter_brand[] = 0; // добавить к выборке общие фильтры/атрибуты

            $filters = AttributeList::find() // отбираем атрибуты (в данном случае только бренды)
                ->where(['as_filter' => 1, 'category_id' => $where_filter_brand])
                ->orderBy('sort_position')
                ->all();

            // получаем массив ID`шников фильтров
            $filter_ids = [];
            foreach ($filters as $filter) {
                $filter_ids[] = $filter->id;
            }

            // получаем масив названия фильтров в формате id => name
            $filter_id_name = [];
            foreach ($filters as $one_filter) {
                $name = 'name_' . Yii::$app->language;
                $filter_id_name[$one_filter->id] = $one_filter->$name;
            }

            // вибираем з БД значение фильтров
            $filter_values = AttributeValue::find()
                ->where(['attribute_id' => $filter_ids])
                ->orderBy('sort_position')
                ->all();

            // создаем масив с названия фильтров и значениями каждого фильта
            $filters_arr = [];
            foreach ($filters as $f) {
                $item = [];
                $item['values'] = [];
                $name = 'name_' . Yii::$app->language;
                $item['name'] = $f->$name;
                $item['id'] = $f->id;
                foreach ($filter_values as $v) {
                    if ($v->attribute_id == $f->id) {
                        $item['values'][] = $v;
                    }
                }
                $filters_arr[] = $item;
            }

            $param_where = [];
            $sort = '';

            if ( isset($_GET['sort']) ) { // проверяем  наличие критерия для сортировки
                $sort = Product::getSortBy ($_GET['sort']);
            }

            $param_where['category_id'] = $category_id;
            $param_where['status'] = 1;

            if ( Yii::$app->request->get('filter') ) {
                $filters = Yii::$app->request->get('filter');           // текущие фильтры - получаем с адресной строки
                $current_filters_values = explode(",", $filters);       // преобразовуем текущие фильтры в массив

                // построить массив значения фильтров slug => id
                $filter_value_arr_slug_id = [];
                foreach ($filter_values as $filter_item) {
                    $filter_value_arr_slug_id[$filter_item->slug] = $filter_item->id;
                }
                // получаем ID текущих фильтров
                $filter_values_ids = [];
                foreach ($current_filters_values as $cur_value) {
                    $filter_values_ids[] = $filter_value_arr_slug_id[$cur_value];
                }
                // получаем текущие связанные атрибуты
                $attribute_relation = RelationsProductAtribute::find()->select(['product_id', 'attribute_id'])->where(['attribute_value_id' => $filter_values_ids])->all();

                // получаем ID продуктов удовлетовряющих заданные фильтры
                // и массив используемых атрибутов
                $product_ids = [];
                $attributes = [];
                foreach ($attribute_relation as $attr_rel) {
                    $product_ids[] = $attr_rel->product_id;
                    $attributes[] = $attr_rel->attribute_id;
                }
                $attributes = array_unique($attributes);
                $count_filters = count($attributes);

                $product_ids_counter = array_count_values ($product_ids); // создаем массив с количеством id каждого товара ['id' => 'count', ...]

                $curent_product_ids = [];
                foreach ($product_ids_counter as $key => $value) {
                    if ($value == $count_filters) {                     // проверяем равно ли количество id товара количеству фильтров
                        $curent_product_ids[] = $key;
                    } else {
                        continue;
                    }
                }

                if (count($curent_product_ids) != 0) {
                    $param_where['id'] = $curent_product_ids;
                } else {
                    $param_where['id'] = 0;
                }

            }

            $query = Product::find()
                ->select('*')
                ->where($param_where)
                //->andFilterWhere(['or', ['id'=> $_GET['category']], ['slug'=> $_GET['category']]])
                ->orderBy($sort);

            $countQuery = clone $query;
            $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
            $products = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

	        return $this->render('category', [
	            //'id' => $id,
                'filters' => $filters_arr,
                'cur_category' => $cur_category,
	            'category' => $category_id,
                'products' => $products,
                'pages' => $pages,
	        ]);

// render index.php
        } else {

            $filters = AttributeList::find() // отбираем атрибуты (в данном случае только бренды)
                ->where(['as_filter' => 1, 'category_id' => 0])
                ->orderBy('sort_position')
                ->all();

            // получаем массив ID`шников фильтров
            $filter_ids = [];
            foreach ($filters as $filter) {
                $filter_ids[] = $filter->id;
            }

            // получаем масив названия фильтров в формате id => name
            $filter_id_name = [];
            foreach ($filters as $one_filter) {
                $name = 'name_' . Yii::$app->language;
                $filter_id_name[$one_filter->id] = $one_filter->$name;
            }

            // вибираем з БД значение фильтров
            $filter_values = AttributeValue::find()
                ->where(['attribute_id' => $filter_ids])
                ->orderBy('sort_position')
                ->all();

            // создаем масив с названия фильтров и значениями каждого фильта
            $filters_arr = [];
            foreach ($filters as $f) {
                $item = [];
                $item['values'] = [];
                $name = 'name_' . Yii::$app->language;
                $item['name'] = $f->$name;
                $item['id'] = $f->id;
                foreach ($filter_values as $v) {
                    if ($v->attribute_id == $f->id) {
                        $item['values'][] = $v;
                    }
                }
                $filters_arr[] = $item;
            }

            $param_where = [];
            $sort = '';

            if ( isset($_GET['sort']) ) { // проверяем  наличие критерия для сортировки
                $sort = Product::getSortBy ($_GET['sort']);
            }

            $param_where['status'] = 1;

            if ( Yii::$app->request->get('filter') ) {
                $filters = Yii::$app->request->get('filter');           // текущие фильтры - получаем с адресной строки
                $current_filters_values = explode(",", $filters);       // преобразовуем текущие фильтры в массив

                $count_filters = count($current_filters_values);        //количество фильтров

                $filter_value_arr_slug_id = [];
                foreach ($filter_values as $filter_item) {
                    $filter_value_arr_slug_id[$filter_item->slug] = $filter_item->id;
                }
                $filter_values_ids = [];
                foreach ($current_filters_values as $cur_value) {
                    $filter_values_ids[] = $filter_value_arr_slug_id[$cur_value];
                }
                // получаем текущие связанные атрибуты
                $attribute_relation = RelationsProductAtribute::find()->select(['product_id', 'attribute_id'])->where(['attribute_value_id' => $filter_values_ids])->all();

                // получаем ID продуктов удовлетовряющих заданные фильтры
                // и массив используемых атрибутов
                $product_ids = [];
                $attributes = [];
                foreach ($attribute_relation as $attr_rel) {
                    $product_ids[] = $attr_rel->product_id;
                    $attributes[] = $attr_rel->attribute_id;
                }
                $attributes = array_unique($attributes);
                $count_filters = count($attributes);

                $product_ids_counter = array_count_values ($product_ids); // создаем массив с количеством id каждого товара ['id' => 'count', ...]

                $curent_product_ids = [];
                foreach ($product_ids_counter as $key => $value) {
                    if ($value == $count_filters) {                     // проверяем равно ли количество id товара количеству фильтров
                        $curent_product_ids[] = $key;
                    } else {
                        continue;
                    }
                }

                if (count($curent_product_ids) != 0) {
                    $param_where['id'] = $curent_product_ids;
                } else {
                    $param_where['id'] = 0;
                }

            }

            $query = Product::find()
                ->select('*')
                ->where($param_where)
                //->andFilterWhere(['or', ['id'=> $_GET['category']], ['slug'=> $_GET['category']]])
                ->orderBy($sort);

            $countQuery = clone $query;
            $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
            $products = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            $category_slugs = Category::find()
                ->select(['id', 'slug'])
                ->all();
            $category_slugs = ArrayHelper::map($category_slugs, 'id', 'slug');

            return $this->render('index', [
                'filters' => $filters_arr,
                'category_slugs' => $category_slugs,
                'products' => $products,
                'pages' => $pages,
            ]);
        }
    }

    public function actionReview()
    {
        if (
            Yii::$app->request->post('id') != '' &&
            Yii::$app->request->post('user_name') != '' &&
            Yii::$app->request->post('stars') != '' &&
            Yii::$app->request->post('comment') != ''
        ) {

            $id = Yii::$app->request->post('id');
            $user_name = Yii::$app->request->post('user_name');
            $stars = Yii::$app->request->post('stars');
            $comment = Yii::$app->request->post('comment');
            $user_id = (!Yii::$app->session->get('user_id')) ? 0 : Yii::$app->session->get('user_id');

            $review = new Review();
            $review->product_id = $id;
            $review->user_name = $user_name;
            $review->user_id = $user_id;
            $review->review_text = $comment;
            $review->date_create = date('Y-m-d H:i:s');
            $review->status = 0;
            $review->stars = $stars;

            if ($review->save(false)) {
                echo json_encode([
                    'status' => true,
                    'mess' => 'Коментарий отправлен на модерацию. Он будет опубликован после одобрения администратором.'
                ]);
            } else {
                echo json_encode([
                    'status' => 0,
                    'mess' => 'Error'
                ]);
            }
        } else {
            if ( Yii::$app->request->post('id') == '' ) {
                echo json_encode([
                    'status' => 0,
                    'mess' => 'Error: not fount product',
                ]);
            } else if ( Yii::$app->request->post('user_name') == '' ) {
                echo json_encode([
                    'status' => 0,
                    'mess' => 'Error: User name empty',
                ]);
            } else if ( Yii::$app->request->post('stars') == '' ) {
                echo json_encode([
                    'status' => 0,
                    'mess' => 'Error: Stars empty',
                ]);
            } else if ( Yii::$app->request->post('comment') == '' ) {
                echo json_encode([
                    'status' => 0,
                    'mess' => 'Error: Comment empty',
                ]);
            }
        }
    }

}
