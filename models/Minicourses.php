<?php


namespace app\models;


use yii\db\ActiveRecord;

class Minicourses extends ActiveRecord
{
    public $img;


    public function afterFind()
    {
        $this->img = "/web/images/minicourses/.$this->alias.png";

    }

}