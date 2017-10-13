<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;




class BillEditMainForm extends Model
{
    public $id;
    public $date;
    public $payer_id;
    public $info;
    public $header_id;
    public $footer_id;


    public function rules()
    {
        return [
            [['date'], 'required'],
            [[   'id',
                'date',
                'payer_id',
                'info',
                'header_id',
                'footer_id',


            ], 'trim'],
        ];
    }

    public function editBill($payers_id_name)
    {
        if ($this->validate()) {

            $payer_id = array_search($this->payer_id, $payers_id_name);//в $this->payer_id приходит имя а не id
            $data_array = array(

                'id' =>$this->id,
                'date' => $this->date,
                'payer_id' => $payer_id,
                'info' => $this->info,
                'header_id' => $this->header_id,
                'footer_id' => $this->footer_id,


            );

            Bills::editBill($data_array);
            return true;
        }
        return false;
    }
}