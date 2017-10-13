<?php


namespace app\controllers;



use app\components\debugger\Debugger;
use app\models\FooterHeader;
use app\models\Logo;
use app\models\MainSettings;
use app\models\MonthYearServicesForm;
use app\models\Services;
use app\models\UnitAddForm;
use app\models\UnitEditForm;
use app\models\SettingsEditForm;
use app\models\LogoLoadForm;
use app\models\Units;
use app\models\Settings;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\HeaderAddForm;
use app\models\HeaderEditForm;
use app\models\FooterAddForm;
use app\models\FooterEditForm;
use app\models\MainSettingsEditForm;
use yii\web\UploadedFile;

class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer','edit-setting','edit-main-settings','edit-logo'],
                'rules' => [
                    [
                        'controllers' => ['settings'],
                        'actions' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer', 'edit-setting','edit-main-settings','edit-logo'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['settings'],
                        'actions' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer', 'edit-setting','edit-main-settings','edit-logo'],
                        'allow' => false,
                        'roles' => ['?'],

                    ],
                ],
            ],

        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

    public function actionIndex()
    {
        $main_settings_data = MainSettings::getSettingsById(0);

        $UnitAddForm = new UnitAddForm();
        $units_data = Units::getUnitsList();
        if ($UnitAddForm->load(Yii::$app->request->post()) && $UnitAddForm->addUnit()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        $HeaderAddForm = new HeaderAddForm();
        $headers_data = FooterHeader::getHeaderList();
        if ($HeaderAddForm->load(Yii::$app->request->post()) && $HeaderAddForm->addHeader()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        $FooterAddForm = new FooterAddForm();
        $footers_data = FooterHeader::getFooterList();
        if ($FooterAddForm->load(Yii::$app->request->post()) && $FooterAddForm->addFooter()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }


        $MonthYearServicesForm = new MonthYearServicesForm();
        $services_with_monthyear_data = Services::getServicesWithMonthYearList();
        if ($MonthYearServicesForm->load(Yii::$app->request->post()) && $MonthYearServicesForm->addMonthYear()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }



       $logo_data = Logo::getActiveLogo();

        $settings_data = Settings::getSettingsList();



        $services_data = Services::getServicesList();
        $services_id_name = array();
        foreach ($services_data as $k => $v) {
            $services_id_name[$v['id']] = $v['name'];
        }

        return $this->render('index',[
            'UnitAddForm' => $UnitAddForm,
            'MonthYearServicesForm' => $MonthYearServicesForm,
            'units_data' => $units_data,
            'headers_data' => $headers_data,
            'HeaderAddForm' => $HeaderAddForm,
            'footers_data' => $footers_data,
            'FooterAddForm' => $FooterAddForm,
            'main_settings_data' => $main_settings_data,
            'settings_data' => $settings_data,
            'services_id_name_select' => $services_id_name,
            'logo_data' => $logo_data,
            'services_with_monthyear_data' => $services_with_monthyear_data,
        ]);
    }

    public function actionEditUnit()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return  $this->redirect(["/settings"]);
        }
        $unit = Units::getUnitById($id);
        $UnitEditForm = new UnitEditForm();
        if ($UnitEditForm->load(Yii::$app->request->post()) && $UnitEditForm->editUnit()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        return $this->render('edit-unit',[
            'UnitEditForm' => $UnitEditForm,
            'unit' => $unit,
        ]);
    }

    public function actionDeleteUnit()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return  $this->redirect(["/settings"]);
        }

        Units::deleteToArhiveUnit($id);
        return $this->redirect(["/settings"]);
    }
    public function actionDeleteHeader()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return  $this->redirect(["/settings"]);
        }

        FooterHeader::deleteToArhiveFooterHeader($id);
        return  $this->redirect(["/settings"]);
    }

    public function actionEditHeader()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return  $this->redirect(["/settings"]);
        }
        $header = FooterHeader::getHeaderFooterById($id);
        $HeaderEditForm = new HeaderEditForm();
        if ($HeaderEditForm->load(Yii::$app->request->post()) && $HeaderEditForm->editHeader()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        return $this->render('edit-header',[
            'HeaderEditForm' => $HeaderEditForm,
            'header' => $header,
        ]);
    }

    public function actionDeleteFooter()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return $this->redirect(["/settings"]);
        }

        FooterHeader::deleteToArhiveFooterHeader($id);
        return $this->redirect(["/settings"]);
    }

    public function actionEditFooter()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return $this->redirect(["/settings"]);
        }
        $footer = FooterHeader::getHeaderFooterById($id);
        $FooterEditForm = new FooterEditForm();
        if ($FooterEditForm->load(Yii::$app->request->post()) && $FooterEditForm->editFooter()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        return $this->render('edit-footer',[
            'FooterEditForm' => $FooterEditForm,
            'footer' => $footer,
        ]);
    }
    public function actionEditMainSettings()
    {

        $main_settings_data = MainSettings::getSettingsById(0);
        $MainSettingsEditForm = new MainSettingsEditForm();
        if ($MainSettingsEditForm->load(Yii::$app->request->post()) && $MainSettingsEditForm->editMainSettings()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        return $this->render('edit-main-settings',[
            'MainSettingsEditForm' => $MainSettingsEditForm,
            'main_settings_data' => $main_settings_data,
        ]);

    }

    public function actionEditSetting()
    {
        $key = Yii::$app->request->get('key');
        if(!$key){
            return  $this->redirect(["/settings"]);
        }
        $setting = Settings::getSettingByKey($key);
       // Debugger::PrintR($setting);
       // Debugger::testDie();
        $SettingsEditForm = new SettingsEditForm();
        if ($SettingsEditForm->load(Yii::$app->request->post()) && $SettingsEditForm->editSetting()) {
            if (!Yii::$app->request->isPjax) {
                return $this->redirect(["/settings"]);
            }
        }

        return $this->render('edit-setting',[
            'SettingsEditForm' => $SettingsEditForm,
            'setting' => $setting,
        ]);
    }

    public function actionEditLogo()
    {
        $LogoLoadForm = new LogoLoadForm();
        $logos_data = Logo::getLogosList();
        if ($LogoLoadForm->load(Yii::$app->request->post())) {
            $LogoLoadForm->logo = UploadedFile::getInstance($LogoLoadForm, 'logo');
            if ($LogoLoadForm->upload()) {

                // file is uploaded successfully

                return $this->redirect(["/settings/edit-logo"]);
            }

        }

        return $this->render('edit-logo',[
            'LogoLoadForm' => $LogoLoadForm,
            'logos_data' => $logos_data,
        ]);
    }

    public function actionDeleteLogo()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return $this->redirect(["/settings/edit-logo"]);
        }
        $result = Logo::deleteLogo($id);

        if($result == 1){
            return $this->redirect(["/settings/edit-logo"]);
    }elseif($result == -2){
            Yii::$app->session->setFlash('failDeleteLogo', ['value' => "Изображение (id = $id) используется в счетах и не может быть удален!"]);
            return $this->redirect(["/settings/edit-logo"]);
        }else{
            Yii::$app->session->setFlash('failDeleteLogo', ['value' => "Изображение (id = $id) установленно как логотип по умолчанию и не может быть удалено!"]);
            return $this->redirect(["/settings/edit-logo"]);
        }
    }

    public function actionChangeLogo()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return $this->redirect(["/settings/edit-logo"]);
        }


        Logo::activationLogo($id);

            return $this->redirect(["/settings/edit-logo"]);
    }

    public function actionDeleteMonthYearServices()
    {
        $id = Yii::$app->request->get('id');
        if(!$id){
            return $this->redirect(["/settings"]);
        }
        Services::deleteMonthYear($id);
        return $this->redirect(["/settings"]);
    }

}