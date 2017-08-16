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
        $services = self::find()->asArray()->all();

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


        //return true;
    }


}