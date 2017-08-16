<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Payers extends  ActiveRecord
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
        return '{{payers}}';
    }

    public static function getPayersList()
    {
        $payers = self::find()->asArray()->all();

        return $payers;
    }
    public static function insertPayer($data_array)
    {

        $payer = new Payers();
        $payer->name = $data_array['name'];
        $payer->contact_person = $data_array['contact_person'];
        $payer->phone = $data_array['phone'];
        $payer->person_id = $data_array['person_id'];
        $payer->certificat_pdv_id = $data_array['certificat_pdv_id'];
        $payer->address_ur = $data_array['address_ur'];
        $payer->address_connection = $data_array['address_connection'];
        $payer->address_post = $data_array['address_post'];
        $payer->email = $data_array['email'];
        $payer->contract_id = $data_array['contract_id'];
        $payer->contract_date = $data_array['contract_date'];
        $payer->save();
    }
    public static function getPayerById($id)
    {
        $payer = Payers::findOne($id);


        return $payer;

    }
    public static function editPayer($data_array)
    {
        $payer = Payers::findOne($data_array['id']);

        $payer->name = $data_array['name'];
        $payer->contact_person = $data_array['contact_person'];
        $payer->phone = $data_array['phone'];
        $payer->person_id = $data_array['person_id'];
        $payer->certificat_pdv_id = $data_array['certificat_pdv_id'];
        $payer->address_ur = $data_array['address_ur'];
        $payer->address_connection = $data_array['address_connection'];
        $payer->address_post = $data_array['address_post'];
        $payer->email = $data_array['email'];
        $payer->contract_id = $data_array['contract_id'];
        $payer->contract_data = $data_array['contract_data'];
        $payer->save();
    }

    public static  function deletePayer($id)
    {
       $payer = Payers::findOne($id);
        $payer->delete();

    }


}