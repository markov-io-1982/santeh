<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['index', 'logout' , 'crop'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$new_orders = Order::findAll(['order_status_id']);

        return $this->render('index', [
            //'new_orders' => $new_orders,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionLanguage () {
        if ( isset($_POST['lang']) ) {
            Yii::$app->language = $_POST['lang']; // устанавливается язык приложения
            $cookie = new yii\web\Cookie([ 
                'name' => 'lang',
                'value' => $_POST['lang']
            ]);

            Yii::$app->getResponse()->getCookies()->add($cookie); // текущий язык записывается в cookie
        }
    }

    public function actionCrop()
    {

        if (Yii::$app->request && Yii::$app->request->post('x1') && Yii::$app->request->post('x2') && Yii::$app->request->post('y1') && Yii::$app->request->post('y2') ) {

            $request = Yii::$app->request;

            $x1 = $request->post('x1');
            $x2 = $request->post('x2');
            $y1 = $request->post('y1');
            $y2 = $request->post('y2');

            $h = $request->post('h');
            $w = $request->post('w');

            $image_source = $request->post('image_source');

            $image_height = $request->post('image_height');
            $image_width = $request->post('image_width');

            if (empty($w)) {
            //nothing selected
            return;
            }
            $image = imagecreatefromjpeg($image_source);

            $width = imagesx($image);
            $height = imagesy($image);
            // $width = imagesx($image_width);
            // $height = imagesy($image_height);

            $resized_width = ((int) $x2) - ((int) $x1);
            $resized_height = ((int) $y2) - ((int) $y1);

            $resized_image = imagecreatetruecolor($resized_width, $resized_height);
            imagecopyresampled($resized_image, $image, 0, 0, (int) $x1, (int) $y1, $width, $height, $width, $height);
            imagejpeg($resized_image, $image_source);           
        }
        else {
            return $this->render('crop', [
                //'model' => $model,
            ]);        
        }

    }

}
