<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class FooterHeader extends  ActiveRecord
{


    public function rules()
    {
        return [
            [['name','text'], 'required'],

        ];
    }

    public static function tableName()
    {
        return '{{footer_header}}';
    }

    public static function getHeaderList()
    {
        $headers = self::find()->where(['footer_header' =>1, 'delete' => -1])->asArray()->all();

        return $headers;
    }

    public static function getHeaderArhiveList()
    {
        $headers = self::find()->where(['footer_header' =>1, 'delete' => 1])->asArray()->all();

        return $headers;
    }

    public static function getFooterList()
    {
        $footers = self::find()->where(['footer_header' => 2, 'delete' => -1])->asArray()->all();

        return $footers;
    }
    public static function getFooterArhiveList()
    {
        $footers = self::find()->where(['footer_header' => 2, 'delete' => 1])->asArray()->all();

        return $footers;
    }
    public static function insertFooterHeader($name,$footer_header, $text)
    {
        $fh = new FooterHeader();
        $fh->name = $name;
        $fh->footer_header = $footer_header;
        $fh->text = $text;
        $fh->save();
    }
    public static function getHeaderFooterById($id)
    {
        $fh = FooterHeader::findOne($id);


        return $fh;

    }
    public static function editFooterHeader($id, $name,$footer_header, $text)
    {
        $fh = FooterHeader::findOne($id);
        $fh->name = $name;
        $fh->footer_header = $footer_header;
        $fh->text = $text;
        $fh->save();
    }

    public static  function deleteFooterHeader($id)
    {
       $fh = FooterHeader::findOne($id);
        $fh->delete();


        //return true;
    }

    public static  function deleteToArhiveFooterHeader($id)
    {
        $fh = FooterHeader::findOne($id);
        $fh->delete = 1;
        $fh->save();
    }
    public static  function returnFromArhiveFooterHeader($id)
    {
        $fh = FooterHeader::findOne($id);
        $fh->delete = -1;
        $fh->save();
    }


}