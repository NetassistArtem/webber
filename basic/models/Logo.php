<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Logo extends  ActiveRecord
{


    public function rules()
    {
        return [
            [['url'], 'required'],
            ['url', 'trim'],
        ];
    }

    public static function tableName()
    {
        return '{{logo}}';
    }

    public static function getLogosList()
    {
        $logos = self::find()->asArray()->all();

        return $logos;
    }



    public static function loadLogo($url)
    {
        $logo = new Logo();
        $logo->url = $url;
        $logo->save();
    }
    public static function getLogoById($id)
    {
        $logo = self::findOne($id);
        return $logo;
    }

    public static function getActiveLogo()
    {
        $logo_selected = self::find()->where(['selected' => 1])->asArray()->all();


        return $logo_selected;

    }

    public static function inactivateLogo()
    {
        $logo_selected = self::find()->where(['selected' => 1])->all();
        foreach($logo_selected as $k => $v){
            $v->selected = -1;
            $v->save();
        }
    }

    public static function activationLogo($id)
    {
        self::inactivateLogo();
        $logo = self::findOne($id);

        $logo->selected = 1;
        $logo->save();
    }

    public static  function deleteLogo($id)
    {
        $logo = self::findOne($id);
        if($logo->selected == 1){
            return -1;
        }
        $in_bills_use = Bills::findBillsWithLogo($id);
        if(empty($in_bills_use)){
            unlink($logo->url);
            $logo->delete();

            return 1;
        }else{
            return -2;
        }

    }



}