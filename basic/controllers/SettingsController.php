<?php


namespace app\controllers;



use app\models\FooterHeader;
use app\models\UnitAddForm;
use app\models\UnitEditForm;
use app\models\Units;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\HeaderAddForm;
use app\models\HeaderEditForm;
use app\models\FooterAddForm;
use app\models\FooterEditForm;

class SettingsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer'],
                'rules' => [
                    [
                        'controllers' => ['settings'],
                        'actions' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer'],
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'controllers' => ['settings'],
                        'actions' => ['index','edit-unit','delete-unit', 'delete-header', 'edit-header', 'delete-footer', 'edit-footer'],
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

        return $this->render('index',[
            'UnitAddForm' => $UnitAddForm,
            'units_data' => $units_data,
            'headers_data' => $headers_data,
            'HeaderAddForm' => $HeaderAddForm,
            'footers_data' => $footers_data,
            'FooterAddForm' => $FooterAddForm,
        ]);
    }

    public function actionEditUnit()
    {
        $id = Yii::$app->request->get('id');
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

        Units::deleteUnit($id);
        $this->redirect(["/settings"]);
    }
    public function actionDeleteHeader()
    {
        $id = Yii::$app->request->get('id');

        FooterHeader::deleteFooterHeader($id);
        $this->redirect(["/settings"]);
    }

    public function actionEditHeader()
    {
        $id = Yii::$app->request->get('id');
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

        FooterHeader::deleteFooterHeader($id);
        $this->redirect(["/settings"]);
    }

    public function actionEditFooter()
    {
        $id = Yii::$app->request->get('id');
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

}