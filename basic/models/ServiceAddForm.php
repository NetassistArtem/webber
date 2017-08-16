<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\Units;



class ServiceAddForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'trim'],
        ];
    }

    public function addService()
    {
        if ($this->validate()) {
            Services::insertService($this->name);
            return true;
        }
        return false;
    }
}