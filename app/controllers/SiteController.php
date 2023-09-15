<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\CurrencyCourseValue;
use app\models\CurrencyCourseValueFactory;
use components\helpers\CurrencyCourseHelper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
        CurrencyCourseValue::deleteAll();

        $currencies = CurrencyCourseHelper::CurrencyCoursesCoefficients();
        $currencyCourseValueFactory = new CurrencyCourseValueFactory();

        $currencyCourseValueRus = $currencyCourseValueFactory->create('RUS', 100);
        $currencyCourseValueRus->save();
        $result[] = [
            'code' => $currencyCourseValueRus->code,
            'value' => $currencyCourseValueRus->value
        ];

        foreach ($currencies as $currency) {
            if (in_array($currency->CharCode, CurrencyCourseValue::getActiveСurrencies())) {
                $currencyValue = number_format((CurrencyCourseValue::RUS_NOMINAL * $currency->Nominal) / (float)str_replace(",", ".", $currency->Value), 4);
                $currencyCourseValue = $currencyCourseValueFactory->create($currency->CharCode, $currencyValue);
                $currencyCourseValue->save();

                $result[] = [
                    'code' => $currencyCourseValue->code,
                    'value' => $currencyCourseValue->value
                ];
            }
        }

        return $this->render('index', ['currencies' => $result]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
