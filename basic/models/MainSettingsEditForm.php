<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;




class MainSettingsEditForm extends Model
{
    public $name_dir;
    public $name_firm;
    public $edrpo;
    public $ipn;
    public $certificate;
    public $adress;

    public function rules()
    {
        return [
            [['name_dir','name_firm', 'edrpo', 'ipn', 'certificate', 'adress'], 'required'],
            [['name_dir','name_firm', 'edrpo', 'ipn', 'certificate', 'adress'], 'trim'],
        ];
    }

    public function editMainSettings()
    {
        if ($this->validate()) {
            $data_array = array(
                'id' => 0,
                'name_dir' => $this->name_dir,
                'name_firm' => $this->name_firm,
                'edrpo' => $this->edrpo,
                'ipn' => $this->ipn,
                'certificate' => $this->certificate,
                'adress' => $this->adress,
            );
            //   Debugger::EhoBr($this->name);
            //   Debugger::testDie();
            MainSettings::editSettings($data_array);
            return true;
        }
        return false;
    }

}