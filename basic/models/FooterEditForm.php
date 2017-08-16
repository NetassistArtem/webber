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



class FooterEditForm extends Model
{
    public $name;
    public $id;
    public $text;
    public $footer_header;

    public function rules()
    {
        return [
            [['name','text'], 'required'],
            ['name', 'trim'],
        ];
    }

    public function editFooter()
    {
        if ($this->validate()) {
          //  Units::getUnitById($this->id);
           // Debugger::EhoBr(Yii::$app->request->post('UnitEditForm')['id']);
         //   Debugger::EhoBr($this->name);
         //   Debugger::testDie();
            $post_data = Yii::$app->request->post('FooterEditForm');
            FooterHeader::editFooterHeader($post_data['id'],$this->name, $post_data['footer_header'], $post_data['text']);
            return true;
        }
        return false;
    }

}