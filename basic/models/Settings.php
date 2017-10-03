<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Settings extends  ActiveRecord
{


    public function rules()
    {
        return [
            [['key','value'], 'required'],
            [['key','value'], 'trim'],
        ];
    }

    public static function tableName()
    {
        return '{{settings}}';
    }

    public static function getSettingsList()
    {
        $settings = self::find()->asArray()->all();

        return $settings;
    }



    public static function insertSettings($data_array = array())
    {
        $setting = new Settings();
        $setting->key = $data_array['key'];
        $setting->value = $data_array['value'];
        $setting->name = $data_array['name'];
        $setting->save();
    }
    public static function getSettingById($id)
    {
        $setting = Settings::findOne($id);


        return $setting;

    }

    public static function getSettingByKey($key)
    {
        $setting = self::find()->where(['key' => $key])->one();
        return $setting;
    }

    public static function editSetting($data_array = array())
    {
        $setting = self::getSettingByKey($data_array['key']);

        $setting->value = $data_array['value'];
        $setting->save();
    }

    public static  function deleteSetting($id)
    {
        $setting = self::findOne($id);
        $setting->delete();


        //return true;
    }



}