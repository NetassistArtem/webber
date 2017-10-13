<?php
namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use yii\web\UploadedFile;




class LogoLoadForm extends Model
{
    public $logo;

    public function rules()
    {
        return [
            [['logo'], 'required'],
            ['logo', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024*2],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $url = 'img/' . $this->logo->baseName . '.' . $this->logo->extension;
            $this->logo->saveAs($url);
            Logo::loadLogo($url);//запись данных про изображение в базу данных
            return true;
        } else {
            return false;
        }
    }
}