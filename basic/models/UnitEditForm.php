<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 15.08.17
 * Time: 14:27
 */

namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\Units;



class UnitEditForm extends Model
{
    public $name;
    public $id;

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'trim'],
        ];
    }

    public function editUnit()
    {
        if ($this->validate()) {
          //  Units::getUnitById($this->id);
           // Debugger::EhoBr(Yii::$app->request->post('UnitEditForm')['id']);
         //   Debugger::EhoBr($this->name);
         //   Debugger::testDie();
            Units::editUnit(Yii::$app->request->post('UnitEditForm')['id'],$this->name);
            return true;
        }
        return false;
    }

}