<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\Units;



class UnitAddForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'trim'],
        ];
    }

    public function addUnit()
    {
        if ($this->validate()) {
            Units::insertUnit($this->name);
            return true;
        }
        return false;
    }
}