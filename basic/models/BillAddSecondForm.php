<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;


class BillAddSecondForm extends Model
{

    public $services_id;
    public $units_id;
    public $quantity;
    public $prices;
    public $services_bill_id;


    public function rules()
    {
        return [
            [['services_id'], 'required'],
            [[
                'services_id',
                'units_id',
                'quantity',
                'prices',
                'services_bill_id',
            ], 'trim'],
        ];
    }

    public function addService($id_bill)
    {
        if ($this->validate()) {

            $service_id = $this->services_id ? $this->services_id : -1;
            $units_id = $this->units_id ? $this->units_id : -1;
            $quantity = $this->quantity ?  $this->quantity  : -1;
            $prices = $this->prices ? number_format($this->prices, 2, '.', '')  : -1;

            $data_array = array(

                'id_bill' => $id_bill,
                'services_id' => $service_id,
                'units_id' => $units_id,
                'quantity' => $quantity,
                'prices' => $prices,

            );

            Bills::addService($data_array);
            return true;
        }
        return false;
    }

    public function getBillServices($id_bill)
    {
        $bill_data = Bills::getBillByBillId($id_bill);
        if (!empty($bill_data)) {

            $services_bill_id = $bill_data['services_bill_id'];
            $services = $bill_data['services_id'];
            $units = $bill_data['units_id'];
            $quantity = $bill_data['quantity'];
            $prices = $bill_data['prices'];
            $id = $bill_data['id'];

            $services_bill_id_array = explode(';', $services_bill_id);
            $services_array = explode(';', $services);
            $units_array = explode(';', $units);
            $quantity_array = explode(';', $quantity);
            $prices_array = explode(';', $prices);

            $services_data = array(
                'services_bill_id' => $services_bill_id_array,
                'services' => $services_array,
                'units' => $units_array,
                'quantity' => $quantity_array,
                'prices' => $prices_array,
                'id' => $id,
            );
            return $services_data;

        }
        return null;
    }

    public function deleteBillServices($services_data,$services_bill_id)
    {
        $services_data_new = array(
            'services_bill_id' => '',
            'services' => '',
            'units' => '',
            'quantity' => '',
            'prices' => '',
            'id' => $services_data['id'],
        );

        foreach ($services_data['services_bill_id'] as $k => $v) {
            if ($v != $services_bill_id) {

                $services_data_new['services_bill_id'] .= ';' . $v;
                $services_data_new['services'] .= ';' . $services_data['services'][$k];
                $services_data_new['units'] .= ';' . $services_data['units'][$k];
                $services_data_new['quantity'] .= ';' . $services_data['quantity'][$k];
                $services_data_new['prices'] .= ';' . $services_data['prices'][$k];
            }
        }
        foreach ($services_data_new as $key => $val) {
            $services_data_new[$key]= trim($val, ';');
        }
        if(Bills::deleteService($services_data_new)){
            return true;
        }else{
            return false;
        }

    }

    public function editBillServices($services_data, $services_bill_id)
    {
        if ($this->validate()) {

            $services_data_new = array(
                'services_bill_id' => '',
                'services' => '',
                'units' => '',
                'quantity' => '',
                'prices' => '',
                'id' => $services_data['id'],
            );

            foreach ($services_data['services_bill_id'] as $k => $v) {
                if ($v == $services_bill_id) {
                    $service_id = $this->services_id ? $this->services_id : -1;
                    $units_id = $this->units_id ? $this->units_id : -1;
                    $quantity = $this->quantity ? $this->quantity : -1;
                    $prices = $this->prices ? number_format($this->prices, 2, '.', '') : -1;


                    $services_data_new['services_bill_id'] .= ';' . $v;
                    $services_data_new['services'] .= ';' . $service_id;
                    $services_data_new['units'] .= ';' . $units_id;
                    $services_data_new['quantity'] .= ';' . $quantity;
                    $services_data_new['prices'] .= ';' . $prices;
                } else {
                    $services_data_new['services_bill_id'] .= ';' . $v;
                    $services_data_new['services'] .= ';' . $services_data['services'][$k];
                    $services_data_new['units'] .= ';' . $services_data['units'][$k];
                    $services_data_new['quantity'] .= ';' . $services_data['quantity'][$k];
                    $services_data_new['prices'] .= ';' . $services_data['prices'][$k];
                }

            }
            foreach ($services_data_new as $key => $val) {
                $services_data_new[$key]= trim($val, ';');
            }
            Bills::editService($services_data_new);
            return true;
        }
        return false;

    }

}