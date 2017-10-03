<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Units extends  ActiveRecord
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
        return '{{units}}';
    }

    public static function getUnitsList()
    {
        $units = self::find()->where(['delete' => -1])->asArray()->all();

        return $units;
    }

    public static function getUnitsArhiveList()
    {
        $units = self::find()->where(['delete' => 1])->asArray()->all();

        return $units;
    }

    public static function insertUnit($name)
    {
        $unit = new Units();
        $unit->name = $name;
        $unit->save();
    }
    public static function getUnitById($id)
    {
        $unit = Units::findOne($id);


        return $unit;

    }
    public static function editUnit($id, $name)
    {
        $unit = Units::findOne($id);

        $unit->name = $name;
        $unit->save();
    }

    public static  function deleteUnit($id)
    {
       $unit = Units::findOne($id);
        $unit->delete();


        //return true;
    }
    public static function deleteToArhiveUnit($id)
    {
        $unit = Units::findOne($id);
        $unit->delete = 1;
        $unit->save();

    }

    public static function returnFromArhiveUnit($id)
    {
        $unit = Units::findOne($id);
        $unit->delete = -1;
        $unit->save();

    }


}