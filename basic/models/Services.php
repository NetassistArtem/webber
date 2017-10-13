<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Services extends  ActiveRecord
{


    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'trim'],
        ];
    }

    public static function tableName()
    {
        return '{{services}}';
    }

    public static function getServicesList()
    {
        $services = self::find()->where(['delete' => -1])->asArray()->all();

        return $services;
    }

    public static function getServicesListAll()
    {
        $services = self::find()->asArray()->all();

        return $services;
    }

    public static function getServicesArhiveList()
    {
        $services = self::find()->where(['delete' => 1])->asArray()->all();

        return $services;
    }

    public static function insertService($name)
    {
        $service = new Services();
        $service->name = $name;
        $service->save();
    }
    public static function getServiceById($id)
    {
        $service = Services::findOne($id);


        return $service;

    }
    public static function editService($id, $name)
    {
        $service = Services::findOne($id);

        $service->name = $name;
        $service->save();
    }

    public static  function deleteService($id)
    {
       $service = Services::findOne($id);
        $service->delete();

    }
    public static  function deleteToArhiveService($id)
    {
        $service = Services::findOne($id);
        $service->delete = 1;
        $service->save();

    }
    public static  function returnToArhiveService($id)
    {
        $service = Services::findOne($id);
        $service->delete = -1;
        $service->save();

    }

    public static function addMonthYear($id)
    {

        $service = Services::findOne($id);
        $service->add_month_year = 1;
        $service->save();

    }
    public static function deleteMonthYear($id)
    {

        $service = Services::findOne($id);
        $service->add_month_year = -1;
        $service->save();

    }

    public static function getServicesWithMonthYearList()
    {
        $service = self::find()->where(['add_month_year' => 1])->asArray()->all();

        return $service;
    }


}