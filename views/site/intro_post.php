<?php
/* @var $post */
?>

<div class="post">
    <h1><?php if($post->is_release){ ?> Выпуск № <?= $post->number ?><?php }?> <?= $post->title ?></h1>

    <div class="img">
        <?= \yii\helpers\Html::img('/uploads/'.$post->img,  $options = ['class' => 'postImg', 'style' => ['width' => '180px']])?>
    </div>

    <div class="text">
        <p><?= $post->intro_text?>
    </div>

    <div class="more">
        <a href="<?=\yii\helpers\Url::to(['site/post', 'id' => $post->id])?>">ЧИТАТЬ ПОЛНОСТЬЮ &gt;</a> <!--ссылка на страницу поста-->
    </div>
    <div class="info">
        <div class="date"><?= $post->date?></div>
    </div>
</div>

