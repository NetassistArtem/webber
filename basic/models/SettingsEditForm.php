<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\Settings;



class SettingsEditForm extends Model
{
    public $key;
    public $value;

    public function rules()
    {
        return [
            [['key','value'], 'required'],
            [['key','value'], 'trim'],
        ];
    }

    public function editSetting()
    {
        if ($this->validate()) {
            //  Units::getUnitById($this->id);
            // Debugger::EhoBr(Yii::$app->request->post('UnitEditForm')['id']);
            //   Debugger::EhoBr($this->name);
            //   Debugger::testDie();
            $data_array = array(
                'key' => $this->key,
                'value' => $this->value,
            );
            Settings::editSetting($data_array);
            return true;
        }
        return false;
    }

}