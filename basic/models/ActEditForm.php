<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;




class ActEditForm extends Model
{

    public $date;
    public $act_id;
    public $bill_id;


    public function rules()
    {
        return [

            [['date',
                'act_id',
                'bill_id'

            ], 'trim'],
        ];
    }

    public function editAct()
    {
        if ($this->validate()) {
            $data_array = array(


                'date' => $this->date,
                'act_id' => $this->act_id,
                'bill_id' => $this->bill_id,
            );
            Acts::editBill($data_array);


            return true;
        }
        return false;
    }
}