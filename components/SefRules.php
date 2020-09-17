<?php



namespace app\components;

use yii\web\UrlRule;
use app\models\Sef;

class SefRules extends UrlRule
{
    public $connectionID = 'db';

    public function init()
    {
        if($this->name == null){
            $this->name = __CLASS__;
        }
    }
}