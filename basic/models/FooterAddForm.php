<?php


namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use app\models\FooterHeader;



class FooterAddForm extends Model
{
    public $name;
    public $text;
    public $footer_header;


    public function rules()
    {
        return [
            [['name','text'], 'required'],
            ['name', 'trim'],
        ];
    }

    public function addFooter()
    {
        if ($this->validate()) {
            FooterHeader::insertFooterHeader($this->name, Yii::$app->request->post('FooterAddForm')['footer_header'], $this->text);
            return true;
        }
        return false;
    }
}