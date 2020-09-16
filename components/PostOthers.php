<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Posts;

class PostOthers extends Widget
{
    public $id;

    public function run() {
        $posts = Posts::find()->where(['hide' => 0])->limit(5)->where(['not', ['id' => $this->id]])->orderBy("rand()")->all();

        $trs = "";

        foreach ($posts as $post) {
            $img = Html::tag('img', null, ['src' => $post->img, 'alt' => $post->title]);
            $div_1 = Html::tag('div', $img);
            $a_span = Html::tag('a', '&laquo;'.$post->title.'&raquo;', ['href' => $post->link]);
            $a_span .= Html::tag('span', $post->date, ['class' => 'date']);
            $div_2 = Html::tag('div', $a_span);
            $trs .= Html::tag('div', $div_1.$div_2);
        }
        return Html::tag('table', $trs, ['id' => 'post_others']);
    }

}


