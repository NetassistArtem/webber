<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;




class BillAddMainForm extends Model
{
    public $reall_time;
    public $bill_id;
    public $date;
    public $payer_id;
    public $info;
    public $header_id;
    public $footer_id;
    public $services_id;
    public $units_id;
    public $quantity;
    public $prices;




    public function rules()
    {
        return [
            [['date'], 'required'],
            [['reall_time',

                'date',
                'payer_id',
                'info',
                'header_id',
                'footer_id',
                'services_id',
                'units_id',
                'quantity',
                'prices',

            ], 'trim'],
        ];
    }

    public function addBill()
    {
        if ($this->validate()) {
            $data_array = array(

                'reall_time' => $this->reall_time,
                'date' => $this->date,
                'payer_id' => $this->payer_id,
                'info' => $this->info,
                'header_id' => $this->header_id,
                'footer_id' => $this->footer_id,
                'services_id' => $this->services_id,
                'units_id' => $this->units_id,
                'quantity' => $this->quantity,
                'prices' => $this->prices,
            );

            Bills::insertBill($data_array);
            return true;
        }
        return false;
    }
}