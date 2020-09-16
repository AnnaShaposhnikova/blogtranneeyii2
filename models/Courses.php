<?php


namespace app\models;

use yii\db\ActiveRecord;

class Courses extends ActiveRecord
{
    public $img;
    public $order;
    public $link;

    public static function tableName()
    {
        return "bl_courses";
    }



    public function afterFind()
    {
        $this->link = "/blogrusakov/" . $this->alias;
        $this->img = "/web/images/courses/.$this->alias.png";
        $this->order = "/http://blogrusakov/order?product_ids =" . $this->srs_id;
    }

}