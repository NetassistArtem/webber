<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class MainSettings extends  ActiveRecord
{


    public function rules()
    {
        return [
            [['name_dir','name_firm', 'edrpo', 'ipn', 'certificate', 'adress'], 'required'],
            [['name_dir','name_firm', 'edrpo', 'ipn', 'certificate', 'adress'], 'trim'],
        ];
    }

    public static function tableName()
    {
        return '{{main_data}}';
    }




    public static function getSettingsById($id)
    {
        $settings = self::findOne($id);


        return $settings;

    }
    public static function editSettings($data_array)
    {
        $settings = self::getSettingsById($data_array['id']);


        $settings->name_dir = $data_array['name_dir'];
        $settings->name_firm = $data_array['name_firm'];
        $settings->edrpo = $data_array['edrpo'];
        $settings->ipn = $data_array['ipn'];
        $settings->certificate = $data_array['certificate'];
        $settings->adress = $data_array['adress'];
        $settings->save();
    }


}