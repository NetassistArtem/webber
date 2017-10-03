<?php


namespace app\controllers;



use app\components\debugger\Debugger;
use app\models\FooterHeader;
use app\models\MainSettings;
use app\models\UnitAddForm;
use app\models\UnitEditForm;
use app\models\SettingsEditForm;
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

class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer','edit-setting','edit-main-settings'],
                'rules' => [
                    [
                        'controllers' => ['settings'],
                        'actions' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer', 'edit-setting','edit-main-settings'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['settings'],
                        'actions' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer', 'edit-setting','edit-main-settings'],
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

        $settings_data = Settings::getSettingsList();

        return $this->render('index',[
            'UnitAddForm' => $UnitAddForm,
            'units_data' => $units_data,
            'headers_data' => $headers_data,
            'HeaderAddForm' => $HeaderAddForm,
            'footers_data' => $footers_data,
            'FooterAddForm' => $FooterAddForm,
            'main_settings_data' => $main_settings_data,
            'settings_data' => $settings_data,
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


}