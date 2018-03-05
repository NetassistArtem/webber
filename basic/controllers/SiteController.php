<?php

namespace app\controllers;

use app\components\debugger\Debugger;
use app\models\Acts;
use app\models\Bills;
use app\models\FooterHeader;
use app\models\Logo;
use app\models\MainSettings;
use app\models\Payers;
use app\models\ServiceAddForm;
use app\models\ServiceEditForm;
use app\models\PayerAddForm;
use app\models\PayerEditForm;
use app\models\BillAddMainForm;
use app\models\BillAddSecondForm;
use app\models\BillEditMainForm;
use app\models\ActEditForm;
use app\models\Services;
use app\models\Settings;
use app\models\Units;
use app\models\PrintPdf;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use app\components\Sum\Sum;


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
                    'act-print',
                    'act-view',
                    'act-edit',
                    'bill-view',
                    'arhive-return-footer-header',
                    'arhive',
                    'arhive-return-unit',
                    'arhive-return-service',
                    'arhive-return-payer'
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
                            'act-print',
                            'act-view',
                            'act-edit',
                            'bill-view',
                            'arhive-return-footer-header',
                            'arhive',
                            'arhive-return-unit',
                            'arhive-return-service',
                            'arhive-return-payer'
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
                            'act-print',
                            'act-view',
                            'act-edit',
                            'bill-view',
                            'arhive-return-footer-header',
                            'arhive',
                            'arhive-return-unit',
                            'arhive-return-service',
                            'arhive-return-payer'
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
        $services_per_page = Settings::getSettingByKey('services_per_page');
        $pages = new Pagination(['totalCount' => count($services_data), 'pageSize' => $services_per_page->value]);
        $pages->pageSizeParam = false;

        $services_data_page = array_slice($services_data, $pages->offset, $pages->limit, $preserve_keys = true);



        return $this->render('services', [
            'ServiceAddForm' => $ServiceAddForm,
            'services_data' => $services_data,
            'services_data_page' =>$services_data_page,
            'pages' => $pages,
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

        Services::deleteToArhiveService($id);
        return $this->redirect(["/services"]);
    }
    public function actionArhiveReturnService()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/arhive"]);
        }

        Services::returnToArhiveService($id);
        return $this->redirect(["/arhive"]);
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
        $payers_per_page = Settings::getSettingByKey('payers_per_page');
        $pages = new Pagination(['totalCount' => count($payers_data), 'pageSize' => $payers_per_page->value]);
        $pages->pageSizeParam = false;

        $payers_data_page = array_slice($payers_data, $pages->offset, $pages->limit, $preserve_keys = true);


        return $this->render('payers', [
            'PayerAddForm' => $PayerAddForm,
            'payers_data' => $payers_data,
            'payers_data_page' => $payers_data_page,
            'pages' => $pages,
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

        Payers::deleteToArhivePayer($id);
        return $this->redirect(["/payers"]);
    }

    public function actionArhiveReturnPayer()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            return $this->redirect(["/arhive"]);
        }

        Payers::returnToArhivePayer($id);
        return $this->redirect(["/arhive"]);
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
        $bills_per_page = Settings::getSettingByKey('bills_per_page');
        $pages = new Pagination(['totalCount' => count($bills_data), 'pageSize' => $bills_per_page->value]);
        $pages->pageSizeParam = false;

        $bills_data_page = array_slice($bills_data, $pages->offset, $pages->limit, $preserve_keys = true);


        return $this->render('bills', [

            'bills_data' => $bills_data,
            'bills_data_page' => $bills_data_page,
            'payers_id_name' => $payers_id_name,
            'payers_data' => $payers_data,
            'pages' => $pages,


        ]);
    }

    public function actionAddBillMain()
    {

        Yii::$app->session->remove('bill_id');
        Yii::$app->session->remove('edit');


        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFieldsWithoutDeleted($selected_fields);

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


        if ($BillAddMainForm->load(Yii::$app->request->post()) && $BillAddMainForm->addBill($payers_id_name)) {
            if (!Yii::$app->request->isPjax) {
                $bill_id = Yii::$app->session->get('bill_id');
                $acts = new Acts();
                $acts->createAct($bill_id);

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
     //   Debugger::PrintR($bill_services);

        if ($BillAddSecondForm->load(Yii::$app->request->post())) {
            // Debugger::PrintR($_POST);
            // Debugger::testDie();
            if (Yii::$app->request->post('edit-service')) {

                if ($BillAddSecondForm->editBillServices($bill_services, Yii::$app->request->post('BillAddSecondForm')['services_bill_id'])) {

                    return $this->redirect(["/bills/add-bill-second"]);
                }
            } elseif (Yii::$app->request->post('delete-service')) {
                if ($BillAddSecondForm->deleteBillServices($bill_services, Yii::$app->request->post('BillAddSecondForm')['services_bill_id'])) {

                    return $this->redirect(["/bills/add-bill-second"]);
                }

            } else {
                if ($BillAddSecondForm->addService($bill_id)) {
                    // Debugger::PrintR($_POST);
                    // Debugger::testDie();
                    if (Yii::$app->request->post('save-service')) {
                        Yii::$app->session->remove('bill_id');

                        if (!Yii::$app->request->isPjax) {

                            return $this->redirect(["/bills/bill-view?bill_id=$bill_id"]);
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


        $services_arhive_data = Services::getServicesArhiveList();
        $services_arhive_id_name = array();
        foreach ($services_arhive_data as $k => $v) {
            $services_arhive_id_name[$v['id']] = $v['name'];
        }


        $units_data = Units::getUnitsList();
        $units_id_name = array();
        foreach ($units_data as $k => $v) {
            $units_id_name[$v['id']] = $v['name'];
        }

        $units_arive_data = Units::getUnitsArhiveList();
        $units_arhive_id_name = array();
        foreach ($units_arive_data as $k => $v) {
            $units_arhive_id_name[$v['id']] = $v['name'];
        }

    //    Debugger::PrintR($services_id_name);
        $services_id_name_select = $services_id_name;
        $units_id_name_select = $units_id_name;

       foreach($bill_services['services'] as $k => $v){

           if(isset($services_arhive_id_name[$v])){
               $services_id_name_select[$v] = $services_arhive_id_name[$v].' (услуга удалена)';
           }
           if(isset($units_arhive_id_name[$bill_services['units'][$k]])){
               $units_id_name_select[$bill_services['units'][$k]] = $units_arhive_id_name[$bill_services['units'][$k]].' (единица удалена)';

           }

       }
      //  Debugger::PrintR($services_id_name_select);




        return $this->render('add-bill-second', [
            'BillAddSecondForm' => $BillAddSecondForm,
            'services_data' => $services_id_name,
            'services_id_name_select' => $services_id_name_select,
            'services_arhive_data' => $services_arhive_id_name,
            'units_data' => $units_id_name,
            'units_arhive_data' => $units_arhive_id_name,
            'units_id_name_select' => $units_id_name_select,
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
        $payers_data = Payers::getPayersFieldsWithoutDeleted($selected_fields);
        $payers_id_name = array();
        foreach ($payers_data as $k => $v) {
            $payers_id_name[$v['id']] = $v['name'];
        }
        $payers_arhive_data = Payers::getPayersFieldsArhive($selected_fields);
        $payers_arhive_id_name = array();
        foreach ($payers_arhive_data as $k => $v) {
            $payers_arhive_id_name[$v['id']] = $v['name'];
        }


        $header_data = FooterHeader::getHeaderList();
        $header_id_name = array();
        foreach ($header_data as $k => $v) {
            $header_id_name[$v['id']] = $v['name'];
        }


        $header_arhive_data = FooterHeader::getHeaderArhiveList();
        $header_arhive_id_name = array();
        foreach ($header_arhive_data as $k => $v) {
            $header_arhive_id_name[$v['id']] = $v['name'];
        }



        $footer_data = FooterHeader::getFooterList();
        $footer_id_name = array();
        foreach ($footer_data as $k => $v) {
            $footer_id_name[$v['id']] = $v['name'];
        }

        $footer_arhive_data = FooterHeader::getFooterArhiveList();
        $footer_arhive_id_name = array();
        foreach ($footer_arhive_data as $k => $v) {
            $footer_arhive_id_name[$v['id']] = $v['name'];
        }

        $BillEditMainForm = new BillEditMainForm();
        if ($BillEditMainForm->load(Yii::$app->request->post()) && $BillEditMainForm->editBill($payers_id_name)) {
            if (Yii::$app->request->post('bills-edit-next-button')) {
                Yii::$app->session->set('bill_id', $bill_data['bill_id']);
                Yii::$app->session->set('edit', 1);


                return $this->redirect(["/bills/add-bill-second"]);
            } else {
                $bill_id = $bill_data['bill_id'];
                return $this->redirect(["bills/bill-view?bill_id=$bill_id"]);
            }

        }

        $bills_data = Bills::getBillsList();
        $last_id = array_pop($bills_data)['id'];
        $first_id = array_shift($bills_data)['id'];
        $next_id = ($bill_data['id'] + 1) > $last_id? false : ($bill_data['id'] + 1);
        $prev_id = ($bill_data['id'] - 1) < $first_id? false : ($bill_data['id'] - 1);

        $payers_id_name_select = $payers_id_name;
        if(isset($payers_arhive_id_name[$bill_data['payer_id']])){
            $payers_id_name_select[$bill_data['payer_id']] = $payers_arhive_id_name[$bill_data['payer_id']].' (клиент удален)';
        }

        $header_id_name_select = $header_id_name;
        if(isset($header_arhive_id_name[$bill_data['header_id']])){
            $header_id_name_select[$bill_data['header_id']] = $header_arhive_id_name[$bill_data['header_id']].' (хедер удален)';
        }
        $footer_id_name_select = $footer_id_name;
        if(isset($footer_arhive_id_name[$bill_data['footer_id']])){
            $footer_id_name_select[$bill_data['footer_id']] = $footer_arhive_id_name[$bill_data['footer_id']].' (футер удален)';
        }



        return $this->render('edit-bill-main', [
            'BillEditMainForm' => $BillEditMainForm,
            'bill_data' => $bill_data,
            'payers_id_name' => $payers_id_name,
            'payers_id_name_select' => $payers_id_name_select,
            'payers_data' => $payers_data,
            'header_data' => $header_id_name,
            'header_id_name_select' => $header_id_name_select,
            'footer_data' => $footer_id_name,
            'footer_id_name_select' => $footer_id_name_select,
            'next_id' => $next_id,
            'prev_id' => $prev_id,
            'last_id' => $last_id,
            'first_id' => $first_id,
        ]);
    }

    public function actionBillView()
    {
        $id = Yii::$app->request->get('id');
        $bill_id = Yii::$app->request->get('bill_id');
        if (!$id && !$bill_id) {
            return $this->redirect(["/bills"]);
        }
        if ($id) {
            $bill_data = Bills::getBillById($id);
        } else {
            $bill_data = Bills::getBillByBillId($bill_id);
        }
        $bill_id_small = substr(str_replace('-','', $bill_data['bill_id']),2) ;

       // $date_today = Yii::$app->formatter->asDate('now', ' MMMM yyyy');
        $data_for_services_array = explode('-',$bill_data['bill_id']);

        $data_for_services = '  '.Yii::$app->params['ukr-month'][$data_for_services_array[1]]. ' '.$data_for_services_array[0];


        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFieldsWithoutDeleted($selected_fields);
        $payers_data_new = array();
        foreach ($payers_data as $k => $v) {
            $payers_data_new[$v['id']] = $v;
        }

        $payers_arhive_data = Payers::getPayersFieldsArhive($selected_fields);
        $payers_arhive_data_new = array();
        foreach ($payers_arhive_data as $k => $v) {
            $payers_arhive_data_new[$v['id']] = $v;
        }

        $services_data = Services::getServicesList();
       // Debugger::PrintR($services_data);
        $services_data_new = array();
        foreach ($services_data as $k => $v) {
            if($v['add_month_year']== 1){
                $services_data_new[$v['id']] = $v;
                $services_data_new[$v['id']]['name'] = $v['name'].$data_for_services;
            }else{
                $services_data_new[$v['id']] = $v;
            }

        }


        $services_arhive_data = Services::getServicesArhiveList();
        $services_arhive_data_new = array();
        foreach ($services_arhive_data as $k => $v) {

            if($v['add_month_year']== 1){
                $services_arhive_data_new[$v['id']] = $v;
                $services_arhive_data_new[$v['id']]['name'] = $v['name'].$data_for_services;
            }else{
                $services_arhive_data_new[$v['id']] = $v;
            }

        }


        $header_data = FooterHeader::getHeaderList();
        $header_data_new = array();
        foreach ($header_data as $k => $v) {
            $header_data_new[$v['id']] = $v;
        }

        $header_arhive_data = FooterHeader::getHeaderArhiveList();
        $header_arhive_data_new = array();
        foreach ($header_arhive_data as $k => $v) {
            $header_arhive_data_new[$v['id']] = $v;
        }


        $footer_data = FooterHeader::getFooterList();
        $footer_data_new = array();
        foreach ($footer_data as $k => $v) {
            $footer_data_new[$v['id']] = $v;
        }

        $footer_arhive_data = FooterHeader::getFooterArhiveList();
        $footer_arhive_data_new = array();
        foreach ($footer_arhive_data as $k => $v) {
            $footer_arhive_data_new[$v['id']] = $v;
        }


        $units_data = Units::getUnitsList();
        $units_data_new = array();
        foreach ($units_data as $k => $v) {
            $units_data_new[$v['id']] = $v;
        }


        $units_arhive_data = Units::getUnitsArhiveList();
        $units_arhive_data_new = array();
        foreach ($units_arhive_data as $k => $v) {
            $units_arhive_data_new[$v['id']] = $v;
        }


        $services_bill_id_array = explode(';', $bill_data['services_bill_id']);
        $units_id_array = explode(';', $bill_data['units_id']);
        $quantity_array = explode(';', $bill_data['quantity']);
        $prices_array = explode(';', $bill_data['prices']);
        $services_id_array = explode(';', $bill_data['services_id']);


        $bills_data = Bills::getBillsList();
        $last_id = array_pop($bills_data)['id'];
        $first_id = array_shift($bills_data)['id'];
        $next_id = ($bill_data['id'] + 1) > $last_id? false : ($bill_data['id'] + 1);
        $prev_id = ($bill_data['id'] - 1) < $first_id? false : ($bill_data['id'] - 1);

        $logo = Logo::getLogoById($bill_data['logo_id']);
      //  Debugger::PrintR($logo);
       // Debugger::EhoBr($logo);
     //   Debugger::EhoBr($bill_data['logo_id']);
     //   Debugger::testDie();
        $logo_url = $logo->url;

        $sum_writer = new Sum();




        return $this->render('bill-view', [

            'bill_data' => $bill_data,
            'payers_data' => $payers_data_new,
            'payers_arhive_data' => $payers_arhive_data_new,
            'header_data' => $header_data_new,
            'header_arhive_data' => $header_arhive_data_new,
            'footer_data' => $footer_data_new,
            'footer_arhive_data' => $footer_arhive_data_new,
            'services_data' => $services_data_new,
            'services_arhive_data' => $services_arhive_data_new,
            'units_data' => $units_data_new,
            'units_arhive_data' => $units_arhive_data_new,
            'services_bill_id_array' => $services_bill_id_array,
            'units_id_array' => $units_id_array,
            'quantity_array' => $quantity_array,
            'prices_array' => $prices_array,
            'services_id_array' => $services_id_array,
            'next_id' => $next_id,
            'prev_id' => $prev_id,
            'last_id' => $last_id,
            'first_id' => $first_id,
            'logo_url' => $logo_url,
            'bill_id_small' => Bills::toSmallDateFormat($bill_data['bill_id']),
            'sum_writer' => $sum_writer,

        ]);
    }

    public function actionBillPrint()
    {
        $id = Yii::$app->request->get('id');
        $bill_id = Yii::$app->request->get('bill_id');
        if (!$id && !$bill_id) {
            return $this->redirect(["/bills"]);
        }
        if ($id) {
            $bill_data = Bills::getBillById($id);
        } else {
            $bill_data = Bills::getBillByBillId($bill_id);
        }

        $bill_id_small = substr(str_replace('-','', $bill_data['bill_id']),2) ;

        $data_for_services_array = explode('-',$bill_data['bill_id']);

        $data_for_services = '  '.Yii::$app->params['ukr-month'][$data_for_services_array[1]]. ' '.$data_for_services_array[0];



        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFieldsWithoutDeleted($selected_fields);
        $payers_data_new = array();
        foreach ($payers_data as $k => $v) {
            $payers_data_new[$v['id']] = $v;
        }

        $payers_arhive_data = Payers::getPayersFieldsArhive($selected_fields);
        $payers_arhive_data_new = array();
        foreach ($payers_arhive_data as $k => $v) {
            $payers_arhive_data_new[$v['id']] = $v;
        }

        $services_data = Services::getServicesList();
        $services_data_new = array();
        foreach ($services_data as $k => $v) {

            if($v['add_month_year']== 1){
                $services_data_new[$v['id']] = $v;
                $services_data_new[$v['id']]['name'] = $v['name'].$data_for_services;
            }else{
                $services_data_new[$v['id']] = $v;
            }

        }

        $services_arhive_data = Services::getServicesArhiveList();
        $services_arhive_data_new = array();
        foreach ($services_arhive_data as $k => $v) {
            if($v['add_month_year']== 1){
                $services_arhive_data_new[$v['id']] = $v;
                $services_arhive_data_new[$v['id']]['name'] = $v['name'].$data_for_services;
            }else{
                $services_arhive_data_new[$v['id']] = $v;
            }

        }


        $header_data = FooterHeader::getHeaderList();
        $header_data_new = array();
        foreach ($header_data as $k => $v) {
            $header_data_new[$v['id']] = $v;
        }

        $header_arhive_data = FooterHeader::getHeaderArhiveList();
        $header_arhive_data_new = array();
        foreach ($header_arhive_data as $k => $v) {
            $header_arhive_data_new[$v['id']] = $v;
        }

        $footer_data = FooterHeader::getFooterList();
        $footer_data_new = array();
        foreach ($footer_data as $k => $v) {
            $footer_data_new[$v['id']] = $v;
        }

        $footer_arhive_data = FooterHeader::getFooterArhiveList();
        $footer_arhive_data_new = array();
        foreach ($footer_arhive_data as $k => $v) {
            $footer_arhive_data_new[$v['id']] = $v;
        }

        $units_data = Units::getUnitsList();
        $units_data_new = array();
        foreach ($units_data as $k => $v) {
            $units_data_new[$v['id']] = $v;
        }


        $units_arhive_data = Units::getUnitsArhiveList();
        $units_arhive_data_new = array();
        foreach ($units_arhive_data as $k => $v) {
            $units_arhive_data_new[$v['id']] = $v;
        }

        $services_bill_id_array = explode(';', $bill_data['services_bill_id']);
        $units_id_array = explode(';', $bill_data['units_id']);
        $quantity_array = explode(';', $bill_data['quantity']);
        $prices_array = explode(';', $bill_data['prices']);
        $services_id_array = explode(';', $bill_data['services_id']);

        $media_path= Yii::$app->basePath ."/web/";

        $logo = Logo::getLogoById($bill_data['logo_id']);

        $logo_url = $logo->url;

        $sum_writer = new Sum();

        $html = $this->renderPartial('bill-print', [
            'bill_data' => $bill_data,
            'payers_data' => $payers_data_new,
            'payers_arhive_data' => $payers_arhive_data_new,
            'header_data' => $header_data_new,
            'header_arhive_data' => $header_arhive_data_new,
            'footer_data' => $footer_data_new,
            'footer_arhive_data' => $footer_arhive_data_new,
            'services_data' => $services_data_new,
            'services_arhive_data' => $services_arhive_data_new,
            'units_data' => $units_data_new,
            'units_arhive_data' => $units_arhive_data_new,
            'services_bill_id_array' => $services_bill_id_array,
            'units_id_array' => $units_id_array,
            'quantity_array' => $quantity_array,
            'prices_array' => $prices_array,
            'services_id_array' => $services_id_array,
            'media_path' => $media_path,
            'logo_url' => $logo_url,
            'bill_id_small' => Bills::toSmallDateFormat($bill_data['bill_id']),
            'sum_writer' => $sum_writer,
        ]);

        $printPdf = new PrintPdf();
        $printPdf->PrintPdf($html, 'bill_'.$bill_data->bill_id);

    }




    public function actionActEdit()
    {
        $bill_id = Yii::$app->request->get('bill_id');

        if (!$bill_id) {
            return $this->redirect(["/bills"]);
        }
        $act_data = Acts::getActByBillId($bill_id);

        $ActEditForm = new ActEditForm();
        if ($ActEditForm->load(Yii::$app->request->post()) && $ActEditForm->editAct()) {

            return $this->redirect(["bills/act-view?bill_id=$bill_id"]);

        }

        return $this->render('act-edit', [
            'ActEditForm' => $ActEditForm,
            'act_data' => $act_data,
        ]);
    }


    public function actionActView()
    {
        $id = Yii::$app->request->get('id');
        $bill_id = Yii::$app->request->get('bill_id');
        if (!$id && !$bill_id) {
            return $this->redirect(["/bills"]);
        }
        if ($id) {
            $bill_data = Bills::getBillById($id);
        } else {
            $bill_data = Bills::getBillByBillId($bill_id);
        }

        $bill_id_small = substr(str_replace('-','', $bill_data['bill_id']),2) ;

        $data_for_services_array = explode('-',$bill_data['bill_id']);

        $data_for_services = '  '.Yii::$app->params['ukr-month'][$data_for_services_array[1]]. ' '.$data_for_services_array[0];



        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFields($selected_fields);
        $payers_data_new = Payers::getPayerById($bill_data['payer_id']);
       // $payers_data_new = array();
       // foreach ($payers_data as $k => $v) {
         //   $payers_data_new[$v['id']] = $v;
       // }

        $services_data = Services::getServicesListAll();
        $services_data_new = array();
        foreach ($services_data as $k => $v) {
            if($v['add_month_year']== 1){
                $services_data_new[$v['id']] = $v;
                $services_data_new[$v['id']]['name'] = $v['name'].$data_for_services;
            }else{
                $services_data_new[$v['id']] = $v;
            }
        }


        $header_data = FooterHeader::getHeaderListAll();
        $header_data_new = array();
        foreach ($header_data as $k => $v) {
            $header_data_new[$v['id']] = $v;
        }

        $footer_data = FooterHeader::getFooterListAll();
        $footer_data_new = array();
        foreach ($footer_data as $k => $v) {
            $footer_data_new[$v['id']] = $v;
        }

        $units_data = Units::getUnitsListAll();
        $units_data_new = array();
        foreach ($units_data as $k => $v) {
            $units_data_new[$v['id']] = $v;
        }



        $services_bill_id_array = explode(';', $bill_data['services_bill_id']);
        $units_id_array = explode(';', $bill_data['units_id']);
        $quantity_array = explode(';', $bill_data['quantity']);
        $prices_array = explode(';', $bill_data['prices']);
        $services_id_array = explode(';', $bill_data['services_id']);

        $act_data = Acts::getActByBillId($bill_data['bill_id']);
        $main_settings_data = MainSettings::getSettingsById(0);

        $date_month = Yii::$app->formatter->asDate($bill_data['date'], 'yyyy-MM');
        $last_day_month = strtotime("last day of $date_month");




        return $this->render('act-view', [

            'bill_data' => $bill_data,
            'act_data' => $act_data,
            'main_settings_data' => $main_settings_data,
            'last_day_month' => $last_day_month,
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
            'bill_id_small' => Bills::toSmallDateFormat($bill_data['bill_id']),

        ]);
    }

    public function actionActPrint()
    {
        $id = Yii::$app->request->get('id');
        $bill_id = Yii::$app->request->get('bill_id');
        if (!$id && !$bill_id) {
            return $this->redirect(["/bills"]);
        }
        if ($id) {
            $bill_data = Bills::getBillById($id);
        } else {
            $bill_data = Bills::getBillByBillId($bill_id);
        }



        $data_for_services_array = explode('-',$bill_data['bill_id']);

        $data_for_services = '  '.Yii::$app->params['ukr-month'][$data_for_services_array[1]]. ' '.$data_for_services_array[0];


        $selected_fields = array('id', 'name', 'contact_person', 'phone');
        $payers_data = Payers::getPayersFields($selected_fields);
        $payers_data_new = Payers::getPayerById($bill_data['payer_id']);
        // $payers_data_new = array();
        // foreach ($payers_data as $k => $v) {
        //   $payers_data_new[$v['id']] = $v;
        // }

        $services_data = Services::getServicesListAll();
        $services_data_new = array();
        foreach ($services_data as $k => $v) {
            if($v['add_month_year']== 1){
                $services_data_new[$v['id']] = $v;
                $services_data_new[$v['id']]['name'] = $v['name'].$data_for_services;
            }else{
                $services_data_new[$v['id']] = $v;
            }
        }


        $header_data = FooterHeader::getHeaderListAll();
        $header_data_new = array();
        foreach ($header_data as $k => $v) {
            $header_data_new[$v['id']] = $v;
        }

        $footer_data = FooterHeader::getFooterListAll();
        $footer_data_new = array();
        foreach ($footer_data as $k => $v) {
            $footer_data_new[$v['id']] = $v;
        }

        $units_data = Units::getUnitsListAll();
        $units_data_new = array();
        foreach ($units_data as $k => $v) {
            $units_data_new[$v['id']] = $v;
        }

        $services_bill_id_array = explode(';', $bill_data['services_bill_id']);
        $units_id_array = explode(';', $bill_data['units_id']);
        $quantity_array = explode(';', $bill_data['quantity']);
        $prices_array = explode(';', $bill_data['prices']);
        $services_id_array = explode(';', $bill_data['services_id']);

        $act_data = Acts::getActByBillId($bill_data['bill_id']);
        $main_settings_data = MainSettings::getSettingsById(0);

        $date_month = Yii::$app->formatter->asDate($bill_data['date'], 'yyyy-MM');
        $last_day_month = strtotime("last day of $date_month");




        $html = $this->renderPartial('act-print', [

            'bill_data' => $bill_data,
            'act_data' => $act_data,
            'main_settings_data' => $main_settings_data,
            'last_day_month' => $last_day_month,
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
            'bill_id_small' => Bills::toSmallDateFormat($bill_data['bill_id']),

        ]);

        $file_name = isset($act_data->act_id) ? 'act_'.$act_data->act_id : 'act_'.$bill_data['bill_id'];

        $printPdf = new PrintPdf();
        $printPdf->PrintPdf($html, $file_name);
    }

    public function actionArhive()
    {

        $units_data = Units::getUnitsArhiveList();
        $headers_data = FooterHeader::getHeaderArhiveList();
        $footers_data = FooterHeader::getFooterArhiveList();
        $services_data = Services::getServicesArhiveList();
        $payers_data = Payers::getPayersArhiveList();

        return $this->render('arhive', [
            'units_data' => $units_data,
            'footers_data' => $footers_data,
            'headers_data' => $headers_data,
            'services_data' => $services_data,
            'payers_data' => $payers_data,
        ]);
    }


    public function actionArhiveReturnUnit()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return  $this->redirect(["/arhive"]);
        }

        Units::returnFromArhiveUnit($id);
        return $this->redirect(["/arhive"]);
    }

    public function actionArhiveReturnFooterHeader()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return  $this->redirect(["/arhive"]);
        }

        FooterHeader::returnFromArhiveFooterHeader($id);
        return $this->redirect(["/arhive"]);
    }




}
