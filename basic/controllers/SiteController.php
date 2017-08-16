<?php

namespace app\controllers;

use app\models\Bills;
use app\models\Payers;
use app\models\ServiceAddForm;
use app\models\ServiceEditForm;
use app\models\PayerAddForm;
use app\models\PayerEditForm;
use app\models\Services;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
                'only' => [
                    'logout',
                    'invoice',
                    'about',
                    'contact',
                    'services',
                    'delete-service',
                    'edit-service',
                    'payers',
                    'payer',
                    'delete-payer',
                    'edit-payer',
                ],
                'rules' => [
                    [
                        'controllers' => ['site'],
                        'actions' => [
                            'logout',
                            'invoice',
                            'about',
                            'contact',
                            'services',
                            'delete-service',
                            'edit-service',
                            'payers',
                            'payer',
                            'delete-payer',
                            'edit-payer',
                        ],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['site'],
                        'actions' => [
                            'logout',
                            'about',
                            'invoice',
                            'contact',
                            'services',
                            'delete-service',
                            'edit-service',
                            'payers',
                            'payer',
                            'delete-payer',
                            'edit-payer',
                        ],
                        'allow' => false,
                        'roles' => ['?'],

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
     * @return string
     */
    public function actionInvoices()
    {
        $billsModel = new Bills();
        $data = $billsModel->getBillsList();
        return $this->render('invoice',[
            'data' => $data
        ]);
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
    public function actionServices()
    {
        $ServiceAddForm = new ServiceAddForm();

        $services_data = Services::getServicesList();

        if ($ServiceAddForm->load(Yii::$app->request->post()) && $ServiceAddForm->addService()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/services"]);
            }
        }

        return $this->render('services',[
            'ServiceAddForm' => $ServiceAddForm,
            'services_data' => $services_data,
        ]);
    }

    public function actionEditService()
    {
        $id = Yii::$app->request->get('id');
        $service = Services::getServiceById($id);
        $ServiceEditForm = new ServiceEditForm();
        if ($ServiceEditForm->load(Yii::$app->request->post()) && $ServiceEditForm->editService()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/services"]);
            }
        }

        return $this->render('edit-service',[
            'ServiceEditForm' => $ServiceEditForm,
            'service' => $service,
        ]);
    }

    public function actionDeleteService()
    {
        $id = Yii::$app->request->get('id');

        Services::deleteService($id);
        $this->redirect(["/services"]);
    }

    public function actionPayers()
    {
        $PayerAddForm = new PayerAddForm();

        $payers_data = Payers::getPayersList();

        if ($PayerAddForm->load(Yii::$app->request->post()) && $PayerAddForm->addPayer()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/payers"]);
            }
        }

        return $this->render('payers',[
            'PayerAddForm' => $PayerAddForm,
            'payers_data' => $payers_data,
        ]);
    }

}
