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



class PayerEditForm extends Model
{
    public $name;
    public $id;
    public $contact_person;
    public $comment;
    public $phone;
    public $person_id;
    public $certificat_pdv_id;
    public $edrpo;
    public $address_ur;
    public $address_connection;
    public $address_post;
    public $email;
    public $contract_id;
    public $contract_date;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name',
                'contact_person',
                'comment',
                'phone',
                'person_id',
                'certificat_pdv_id',
                'edrpo',
                'address_ur',
                'address_connection',
                'address_post',
                'email',
                'contract_id',
                'contract_date'
            ], 'trim'],
        ];
    }

    public function editPayer()
    {
        if ($this->validate()) {
            $data_array = array(
                'id' => Yii::$app->request->post('PayerEditForm')['id'],
                'name' => $this->name,
                'comment' => $this->comment,
                'contact_person' => $this->contact_person,
                'phone' => $this->phone,
                'person_id' => $this->person_id,
                'certificat_pdv_id' => $this->certificat_pdv_id,
                'edrpo' => $this->edrpo,
                'address_ur' => $this->address_ur,
                'address_connection' => $this->address_connection,
                'address_post' => $this->address_post,
                'email' => $this->email,
                'contract_id' => $this->contract_id,
                'contract_date' => $this->contract_date,
            );
          //  Units::getUnitById($this->id);
           // Debugger::EhoBr(Yii::$app->request->post('UnitEditForm')['id']);
         //   Debugger::EhoBr($this->name);
         //   Debugger::testDie();
            Payers::editPayer($data_array);
            return true;
        }
        return false;
    }

}