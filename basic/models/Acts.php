<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Acts extends  ActiveRecord
{


    public function rules()
    {
        return [
            [['bill_id'], 'required'],
            ['bill_id', 'trim'],
        ];
    }

    public static function tableName()
    {
        return '{{acts}}';
    }


    private function toTimestamp($value)
    {
        return strtotime($value);
    }
    public static function createAct($bill_id)
    {
        $act = new self();
        $act->bill_id = $bill_id;
        $act->save();
    }

    public static function getActById($id)
    {
        $act = self::findOne($id);


        return $act;

    }
    public static function getActByBillId($bill_id)
    {
        $act = self::find()->where(['bill_id' => $bill_id])->one();
        return $act;
    }
    public static function editBill($data_array)
    {
        $act = self::getActByBillId($data_array['bill_id']);
      //  Debugger::PrintR($act);
      //  Debugger::testDie();

        $date_timestamp = self::toTimestamp($data_array['date']);

        $act->date = $date_timestamp;
        $act->act_id = $data_array['act_id'];

        $act->save();
    }


}