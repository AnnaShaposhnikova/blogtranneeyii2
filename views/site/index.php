<?php
use yii\widgets\LinkPager;
/* @var $pagination */
/* @var $active_page */
/* @var $posts */

$this->title = "Личный блог Михаила Русакова";

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Личный блог Михаила Русакова и его выпуски рассылки.'
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'михаил русаков, блог михаил русаков, рассылка михаил русаков'
])

?>
<?php
foreach ($posts as $post)
    echo $this->render('intro_post',[
            'post' => $post,

    ])
?>

<div id="pages">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'firstPageLabel' => 'В начало',
        'lastPageLabel' => 'В конец',
        'prevPageLabel' => '&laquo;'
    ]) ?>
    <span>Страница <?=$active_page?> из <?=$pagination->getPageCount()?></span>
    <div class="clear"></div>
</div>