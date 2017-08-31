<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Bills extends  ActiveRecord
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
        return '{{bills}}';
    }

    public static function getBillsList()
    {
        $bills = self::find()->asArray()->all();

        return $bills;
    }

    public function getLastBill()
    {
        $bill_id = self::find()->max('id');
        $bill_last = self::find()->asArray()->where(['id' => $bill_id])->one();
      return $bill_last;
       // Debugger::PrintR($bill_last);
       // Debugger::Eho($bill);
    }

    private static function createBillId()
    {
        $last_bill_id = self::getLastBill()['bill_id'];
        $last_bill_id_array = explode('-', $last_bill_id);
        $time_now = time();
        $date_now = date('Y-m',$time_now);
        $date_now_array = explode('-',$date_now);
        $n = '';
        if($last_bill_id_array[0] == $date_now_array[0]){
            if($last_bill_id_array[1] == $date_now_array[1]){
                $n= $last_bill_id_array[2] + 1;
            }else{
                $n=1;
            }
        }else{
            $n=1;
        }

        $bill_id = $date_now.'-'.$n;
        return $bill_id;
    }
    private function toTimestamp($value)
    {
        return strtotime($value);
    }
    public static function insertBill($data_array)
    {
        $bill_id = self::createBillId();

        $date_timestamp = self::toTimestamp($data_array['date']);

        $bill = new Bills();

        $bill->reall_time = time();//$data_array['reall_time'];
        $bill->bill_id = $bill_id;//$data_array['bill_id'];//сделать преобразование в нужный формат
        $bill->date = $date_timestamp;
        $bill->payer_id = $data_array['payer_id'];
        $bill->info = $data_array['info'];
        $bill->header_id = $data_array['header_id'];
        $bill->footer_id = $data_array['footer_id'];
      //  $bill->services_id = $data_array['services_id'];
      //  $bill->units_id = $data_array['units_id'];
      //  $bill->quantity = $data_array['quantity'];
      //  $bill->prices = $data_array['prices'];

        $bill->save();
        Yii::$app->session->set('bill_id', $bill_id);
    }

    public static function getBillById($id)
    {
        $bill = self::findOne($id);


        return $bill;

    }
    public static function getBillByBillId($bill_id)
    {
        $bill = self::find()->asArray()->where(['bill_id' => $bill_id])->one();
        return $bill;
    }
    public static function editBill($data_array)
    {
        $bill = self::findOne($data_array['id']);

        $date_timestamp = self::toTimestamp($data_array['date']);


        $bill->date = $date_timestamp;
        $bill->payer_id = $data_array['payer_id'];
        $bill->info = $data_array['info'];
        $bill->header_id = $data_array['header_id'];
        $bill->footer_id = $data_array['footer_id'];

        $bill->save();
    }
    public static function addService($data_array)
    {
        $bill_id = $data_array['id_bill'];
        $bill = self::findOne(['bill_id' => $bill_id]);

      //  Debugger::PrintR($bill);
      //  Debugger::EhoBr($bill->id);
      //  Debugger::testDie();
        if($bill->id){
            $services_bill = $bill->services_bill_id;
            $services = $bill->services_id;
            $units = $bill->units_id;
            $quantity = $bill->quantity;
            $prices = $bill->prices;

            $services_bill_id_array = explode(';' , $services_bill);
            //Debugger::PrintR($services_bill_id_array);
         //   Debugger::EhoBr($services_bill);

            $max_id = max($services_bill_id_array);
           // Debugger::EhoBr($max_id);

            $services_bill_id_new = $max_id +1;


            $bill ->services_bill_id = trim($services_bill.';'.$services_bill_id_new,';') ;
         //   Debugger::EhoBr($bill ->services_bill_id);
           // Debugger::testDie();
            $bill->services_id = trim($services.';'.$data_array['services_id'],';') ;
            $bill->units_id = trim($units.';'.$data_array['units_id'], ';');
            $bill->quantity = trim($quantity.';'.$data_array['quantity'], ';');
            $bill->prices = trim($prices.';'.$data_array['prices'],';');
            $bill->save();


        }
    }
    public static function editService($data_array)
    {
        $bill_id = $data_array['id'];
        $bill = self::findOne($bill_id);
      //  Debugger::PrintR($data_array);
      //  Debugger::testDie();

        if($bill->id){
            $bill ->services_bill_id = $data_array['services_bill_id'];
            $bill->services_id = $data_array['services'];
            $bill->units_id = $data_array['units'];
            $bill->quantity = $data_array['quantity'];
            $bill->prices = $data_array['prices'];
            $bill->save();


        }


    }

    public static function deleteService($data_array)
    {
        self::editService($data_array);
        return true;

    }




}