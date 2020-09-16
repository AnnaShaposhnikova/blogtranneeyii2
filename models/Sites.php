<?php


namespace app\models;


use yii\db\ActiveRecord;

class Sites extends ActiveRecord
{
    public static function tableName()
    {
        return "bl_sites";
    }

}