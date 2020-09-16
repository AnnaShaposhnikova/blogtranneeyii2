<?php
/* @var $post */
?>

<div class="post">
    <h1><?php if($post->is_release){ ?> Выпуск № <?= $post->number ?><?php }?> <?= $post->title ?></h1>

    <div class="img">
        <img src="<?=$post->img?>" alt="<?=$post->title?>" />
    </div>
    <div class="text">
        <p><?php $post->intro_text?>
    </div>
    <div class="more">
        <a href="<?=\yii\helpers\Url::to(['site/post', 'id' => $post->id])?>">ЧИТАТЬ ПОЛНОСТЬЮ &gt;</a> <!--ссылка на страницу поста-->
    </div>
    <div class="info">
        <div class="date"><?= $post->date?></div>
        <div class="hits">
            <img src="/web/images/posts/date.png" alt="" />Просмотров: <?=$post->hits?>			</div>
        <div class="clear"></div>
    </div>
</div>

