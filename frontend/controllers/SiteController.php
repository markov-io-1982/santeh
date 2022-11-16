<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Category;
use frontend\models\Product;
use backend\models\Page;

/**
 * Site controller
 */
class SiteController extends Controller
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
                    //'currency' => ['post'],
                ],
            ],
            // 'httpCache' => [
            //     'class' => 'yii\filters\HttpCache',
            //     //'sessionCacheLimiter' => 'public',
            //     'cacheControlHeader' => 'public, max-age=3600',
            // ],
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

    public function actionSend()
    {
        $send_from = \frontend\models\S::getCont('admin_mail');
        $send_to = \frontend\models\S::getCont('order_mails');
        $send_to = explode(",", $send_to);
        Yii::$app->mailer->compose()
            ->setFrom($send_from)
            ->setTo($send_to)
            ->setSubject('Тема сообщения')
            ->setTextBody('Текст сообщения')
            ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
            ->send();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = Category::find()
            //->select(['id', 'name_'.Yii::$app->language, 'sort_position', 'slug','img', 'description_'.Yii::$app->language ])
            ->where(['status' => 1, 'parent_id' => 0])
            ->all();
        $products = Product::find()
            ->select(['id', 'name_' . Yii::$app->language, 'category_id', 'sort_position', 'price', 'price_old', 'promo_status_id', 'img', 'slug'])
            ->where(['on_main' => 1, 'status' => 1])
            ->andWhere(['>', 'promo_status_id', '0'])
            ->all();
        $promo_statuses = \frontend\models\PromoStatus::find()->all();

        $categories_all = Category::find()
            //->select(['id', 'name_'.Yii::$app->language, 'sort_position', 'slug','img', 'description_'.Yii::$app->language ])
            ->where(['status' => 1])
            ->all();
        $categories_arr = ArrayHelper::map($categories_all, 'id', 'slug');
        return $this->render('index', [
            'categories' => $categories,
            'products' => $products,
            'promo_statuses' => $promo_statuses,
            'categories_arr' => $categories_arr
        ]);
    }

    public function actionPage($id)
    {
        $model = Page::findOne(['slug' => $id, 'status' => 1]);
        if (count($model) == 0) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Page no found'));
        }
        return $this->render('page', [
            'model' => $model
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionLanguage()
    {
        if (isset($_POST['lang'])) {
            Yii::$app->language = $_POST['lang']; // устанавливается язык приложения
            $cookie = new yii\web\Cookie([
                'name' => 'lang',
                'value' => $_POST['lang']
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie); // текущий язык записывается в cookie
        }
    }

    public function actionCurrency()
    {
        if (isset($_POST['curr'])) {
            $cookie = new yii\web\Cookie([
                'name' => 'curr',
                'value' => $_POST['curr']
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);// текущая записывается в cookie
        }
    }


    public function actionUpdatecourse()
    {
        $course = \common\models\Price::updateСourse();
        // $send_from = \frontend\models\S::getCont('email_course');

        // Yii::$app->mailer->compose()
        //     ->setFrom($send_from)
        //     ->setTo($send_from)
        //     ->setSubject('Обновление курса доллара на сайте '.$_SERVER['SERVER_NAME'])
        //     ->setTextBody('На сайте '.$_SERVER['SERVER_NAME'].' был обновлен курс доллара. Сейчас он составляет: '. $course . ' грн.')
        //     ->setHtmlBody('<p>На сайте <b>'.$_SERVER['SERVER_NAME'].'</b> был обновлен курс доллара.</p><p>Сейчас он составляет: <b>'. $course . ' грн.</b></p>')
        //     ->send();
        echo json_encode($course);
    }

    public function actionT()
    {
        $file = file_get_contents("http://resources.finance.ua/ru/public/currency-cash.json");
        $file = json_decode($file);
        $file_array = (array)$file;
        $banks = ArrayHelper::index($file_array['organizations'], 'id');
        $id = '7oiylpmiow8iy1sma7w'; //id ПриватБанка
        $usd_uah = (float)$banks['7oiylpmiow8iy1sma7w']->currencies->USD->ask;
        $eur_uah = (float)$banks['7oiylpmiow8iy1sma7w']->currencies->EUR->ask;
        $rub_uah = (float)$banks['7oiylpmiow8iy1sma7w']->currencies->RUB->ask;
        $usd_eur = $usd_uah / $eur_uah;
        $usd_rub = $usd_uah / $rub_uah;
//7oiylpmiow8iy1sma7w
        echo '<pre>';
        // var_dump($f['organizations'][0]->currencies->USD->ask);
        var_dump($usd_eur);
        var_dump($usd_rub);
        //var_dump($rub_uah);
        echo '<pre>';
    }
    public function actionTest()
    {
        return $this->render('test');
    }
}
