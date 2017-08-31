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

    public function editBill()
    {
        if ($this->validate()) {
            $data_array = array(

                'id' =>$this->id,
                'date' => $this->date,
                'payer_id' => $this->payer_id,
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