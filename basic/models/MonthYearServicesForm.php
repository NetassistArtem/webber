<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\Units;



class MonthYearServicesForm extends Model
{
    public $services_id;

    public function rules()
    {
        return [
            [['services_id'], 'required'],
        ];
    }

    public function addMonthYear()
    {
        if ($this->validate()) {
            Services::addMonthYear($this->services_id);
            return true;
        }
        return false;
    }
}