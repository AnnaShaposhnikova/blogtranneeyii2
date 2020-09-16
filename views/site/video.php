<?php
/* @var $courses */
use yii\helpers\Url;

$this->title = "Видеокурсы";

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Видеокурсы'
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'михаил русаков, блог михаил русаков, рассылка михаил русаков'
]);

include "likes.php";


?>

<?php
    $number = 1;

    foreach ($courses as $course){ ?>
    </hr>
<div class="course">
    <h3><?=$number. '.'.$course->title?> </h3>
    <div class="course_table">
        <div>
            <div>
                <img src="<?= $course->img?>" alt="<?= $course->title?>" />
            </div>
            <p><?=$course->description?>
            </p>
            <?php if($course->did) { ?>
            <div class="course_order">
                <p>ЦЕНА: <span><?=$course->price?></span></p>
                <div class="order">
                    <a href="<?=$course->order?>">ЗАКАЗАТЬ</a>
                </div>
                <div class="more">
                    <a href="<?=Url::to()?>">ПОДРОБНЕЕ</a>//ссылка на страницу курса
                </div>
            </div>
            <?php
            } else {
                include "form_subscribe.php";
            }?>
        </div>
    </div>

    <div class="clear"></div>


<?php
        $number++; }
?>
</div>

