<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Bills extends  ActiveRecord
{

    public static function tableName()
    {
        return '{{bills}}';
    }

    public function getBillsList()
    {
        $bills = Bills::find()->asArray()->all();

        return $bills;
    }


}