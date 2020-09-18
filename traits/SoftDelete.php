<?php
namespace app\traits;

use yii\db\Expression;
trait SoftDelete
{
    public function softDelete(){
       $this->deted_at = new Expression('NOW');
       $this->save();
       return true;
    }


}