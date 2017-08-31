<?php

namespace app\controllers;

use app\components\debugger\Debugger;
use app\models\Bills;
use app\models\FooterHeader;
use app\models\Payers;
use app\models\ServiceAddForm;
use app\models\ServiceEditForm;
use app\models\PayerAddForm;
use app\models\PayerEditForm;
use app\models\BillAddMainForm;
use app\models\BillAddSecondForm;
use app\models\BillEditMainForm;
use app\models\Services;
use app\models\Units;
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
                    'bills',
                    'bill-edit',
                    'bill-delete',
                    'bill-print',
                    'bill-act-print',
                    'add-bill-main',
                    'add-bill-second',
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
                            'bills',
                            'bill-edit',
                            'bill-delete',
                            'bill-print',
                            'bill-act-print',
                            'add-bill-main',
                            'add-bill-second',
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
                            'bills',
                            'bill-edit',
                            'bill-delete',
                            'bill-print',
                            'bill-act-print',
                            'add-bill-main',
                            'add-bill-second',
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
        return $this->render('invoice', [
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

        return $this->render('services', [
            'ServiceAddForm' => $ServiceAddForm,
            'services_data' => $services_data,
        ]);
    }

    public function actionEditService()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/services"]);
        }
        $service = Services::getServiceById($id);
        $ServiceEditForm = new ServiceEditForm();
        if ($ServiceEditForm->load(Yii::$app->request->post()) && $ServiceEditForm->editService()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/services"]);
            }
        }

        return $this->render('edit-service', [
            'ServiceEditForm' => $ServiceEditForm,
            'service' => $service,
        ]);
    }

    public function actionDeleteService()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/services"]);
        }

        Services::deleteService($id);
        return $this->redirect(["/services"]);
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

        return $this->render('payers', [
            'PayerAddForm' => $PayerAddForm,
            'payers_data' => $payers_data,
        ]);
    }

    public function actionEditPayer()
    {
        $id = Yii::$app->request->get('id');


        if (!$id) {
            return $this->redirect(["/payers"]);
        }
        $payer = Payers::getPayerById($id);
        $PayerEditForm = new PayerEditForm();
        if ($PayerEditForm->load(Yii::$app->request->post()) && $PayerEditForm->editPayer()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/payers"]);
            }
        }

        return $this->render('edit-payer', [
            'PayerEditForm' => $PayerEditForm,
            'payer' => $payer,
        ]);
    }

    public function actionPayerView()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/payers"]);
        }
        $payer = Payers::getPayerById($id);

        return $this->render('payer-view', [

            'payer' => $payer,
        ]);
    }

    public function actionDeletePayer()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/payers"]);
        }

        Payers::deletePayer($id);
        return $this->redirect(["/payers"]);
    }

    public function actionBills()
    {
        Yii::$app->session->remove('bill_id');
        Yii::$app->session->remove('edit');

        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFields($selected_fields);

        $payers_id_name = array();
        foreach ($payers_data as $k => $v) {
            $payers_id_name[$v['id']] = $v['name'];
        }

        $bills_data = Bills::getBillsList();

        return $this->render('bills', [

            'bills_data' => $bills_data,
            'payers_id_name' => $payers_id_name,
            'payers_data' => $payers_data,

        ]);
    }

    public function actionAddBillMain()
    {

        Yii::$app->session->remove('bill_id');
        Yii::$app->session->remove('edit');


        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFields($selected_fields);

        $payers_id_name = array();
        foreach ($payers_data as $k => $v) {
            $payers_id_name[$v['id']] = $v['name'];
        }
        $header_data = FooterHeader::getHeaderList();
        $header_id_name = array();
        foreach ($header_data as $k => $v) {
            $header_id_name[$v['id']] = $v['name'];
        }

        $footer_data = FooterHeader::getFooterList();
        $footer_id_name = array();
        foreach ($footer_data as $k => $v) {
            $footer_id_name[$v['id']] = $v['name'];
        }


        $BillAddMainForm = new BillAddMainForm();


        if ($BillAddMainForm->load(Yii::$app->request->post()) && $BillAddMainForm->addBill()) {
            if (!Yii::$app->request->isPjax) {

                return $this->redirect(["/bills/add-bill-second"]);
            }
        }


        return $this->render('add-bill-main', [
            'BillAddMainForm' => $BillAddMainForm,

            'payers_id_name' => $payers_id_name,
            'payers_data' => $payers_data,
            'header_data' => $header_id_name,
            'footer_data' => $footer_id_name,

        ]);
    }

    public function actionAddBillSecond()
    {
        $bill_id = Yii::$app->session->get('bill_id');

        if (!$bill_id) {
            return $this->redirect(["/bills/add-bill-main"]);
        }
        $edit = Yii::$app->session->get('edit');
      //  Yii::$app->session->remove('edit');
        $BillAddSecondForm = new BillAddSecondForm();
        $bill_services = $BillAddSecondForm->getBillServices($bill_id);

        if ($BillAddSecondForm->load(Yii::$app->request->post())) {
           // Debugger::PrintR($_POST);
           // Debugger::testDie();
            if(Yii::$app->request->post('edit-service')){

                if($BillAddSecondForm->editBillServices($bill_services,Yii::$app->request->post('BillAddSecondForm')['services_bill_id'])){

                    return $this->redirect(["/bills/add-bill-second"]);
                }
            }elseif(Yii::$app->request->post('delete-service')){
                if($BillAddSecondForm->deleteBillServices($bill_services,Yii::$app->request->post('BillAddSecondForm')['services_bill_id'])){

                    return $this->redirect(["/bills/add-bill-second"]);
                }

            }else{
                if ($BillAddSecondForm->addService($bill_id)) {
                    // Debugger::PrintR($_POST);
                    // Debugger::testDie();
                    if (Yii::$app->request->post('save-service')) {
                        Yii::$app->session->remove('bill_id');

                        if (!Yii::$app->request->isPjax) {

                            return $this->redirect(["/bills"]);
                        }
                    } elseif (Yii::$app->request->post('more-service')) {

                        return $this->redirect(["/bills/add-bill-second"]);
                    }
                }
            }

        }

        $services_data = Services::getServicesList();
        $services_id_name = array();
        foreach ($services_data as $k => $v) {
            $services_id_name[$v['id']] = $v['name'];
        }

        $units_data = Units::getUnitsList();
        $units_id_name = array();
        foreach ($units_data as $k => $v) {
            $units_id_name[$v['id']] = $v['name'];
        }


        return $this->render('add-bill-second', [
            'BillAddSecondForm' => $BillAddSecondForm,
            'services_data' => $services_id_name,
            'units_data' => $units_id_name,
            'bill_services' => $bill_services,
            'edit' => $edit,
            'bill_id' => $bill_id,

        ]);
    }

    public function actionEditBillMain()
    {
        $id = Yii::$app->request->get('id');


        if (!$id) {
            return $this->redirect(["/bills"]);
        }
        $bill_data = Bills::getBillById($id);


        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFields($selected_fields);

        $payers_id_name = array();
        foreach ($payers_data as $k => $v) {
            $payers_id_name[$v['id']] = $v['name'];
        }
        $header_data = FooterHeader::getHeaderList();
        $header_id_name = array();
        foreach ($header_data as $k => $v) {
            $header_id_name[$v['id']] = $v['name'];
        }

        $footer_data = FooterHeader::getFooterList();
        $footer_id_name = array();
        foreach ($footer_data as $k => $v) {
            $footer_id_name[$v['id']] = $v['name'];
        }

        $BillEditMainForm = new BillEditMainForm();
        if ($BillEditMainForm->load(Yii::$app->request->post()) && $BillEditMainForm->editBill()) {
            if(Yii::$app->request->post('bills-edit-next-button')){
                Yii::$app->session->set('bill_id',$bill_data['bill_id']);
                Yii::$app->session->set('edit',1);

                return $this->redirect(["/bills/add-bill-second"]);
            }else{
                return $this->redirect(["/bills"]);
            }

        }

        return $this->render('edit-bill-main', [
            'BillEditMainForm' => $BillEditMainForm,
            'bill_data' => $bill_data,
            'payers_id_name' => $payers_id_name,
            'payers_data' => $payers_data,
            'header_data' => $header_id_name,
            'footer_data' => $footer_id_name,
        ]);
    }

    public function actionBillView()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/bills"]);
        }
        $bill_data = Bills::getBillById($id);


        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFields($selected_fields);
        $payers_data_new = array();
        foreach($payers_data as $k => $v){
            $payers_data_new[$v['id']] = $v;
        }

        $services_data = Services::getServicesList();
        $services_data_new = array();
        foreach($services_data as $k => $v){
            $services_data_new[$v['id']] = $v;
        }


        $header_data = FooterHeader::getHeaderList();
        $header_data_new = array();
        foreach($header_data as $k => $v){
            $header_data_new[$v['id']] = $v;
        }

        $footer_data = FooterHeader::getFooterList();
        $footer_data_new = array();
        foreach($footer_data as $k => $v){
            $footer_data_new[$v['id']] = $v;
        }

        $units_data = Units::getUnitsList();
        $units_data_new = array();
        foreach($units_data as $k => $v){
            $units_data_new[$v['id']] = $v;
        }

        $services_bill_id_array = explode(';',$bill_data['services_bill_id']);
        $units_id_array = explode(';',$bill_data['units_id']);
        $quantity_array = explode(';',$bill_data['quantity']);
        $prices_array = explode(';',$bill_data['prices']);
        $services_id_array = explode(';',$bill_data['services_id']);


        return $this->render('bill-view', [

            'bill_data' => $bill_data,
            'payers_data' => $payers_data_new,
            'header_data' => $header_data_new,
            'footer_data' => $footer_data_new,
            'services_data' => $services_data_new,
            'units_data' => $units_data_new,
            'services_bill_id_array' => $services_bill_id_array,
            'units_id_array' => $units_id_array,
            'quantity_array' => $quantity_array,
            'prices_array' => $prices_array,
            'services_id_array' => $services_id_array,

        ]);
    }


}
