<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;
use app\components\PostOthers;
use app\models\SearchForm;

AppAsset::register($this);

$action = Yii::$app->controller->action->id;

$model = new SearchForm();

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="/web/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="header">
        <ul class="menu">
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/index'])?>" <?php if($action == "index"){ ?>class = "active"<?php } ?>>Главная</a>
            </li>
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/author'])?>" <?php if($action == "author"){ ?>class = "active"<?php } ?>>Об авторе</a>
            </li>
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/video'])?>" <?php if($action == "video"){ ?>class = "active"<?php } ?>>Видеокурсы</a>
            </li>
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/reviews'])?>"<?php if($action == "reviews"){ ?>class = "active"<?php } ?> >Отзывы</a>
            </li>
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/release'])?>" <?php if($action == "release"){ ?>class = "active"<?php } ?>>Выпуски рассылки</a>
            </li>
            <li>
                <a target="_blank" href="https://myrusakov.ru">Мой сайт</a>
            </li>
            <li>
                <a href="<?= Yii::$app->urlManager->createUrl(['site/sites'])?>" <?php if($action == "sites"){ ?>class = "active"<?php } ?>>Сайты учеников</a>
            </li>
        </ul>
        <div class="clear"></div>
        <div id="header_title">
            <h2><a href="/">блог Михаила Русакова</a></h2>
        </div>

        <div id="search">

           <?php $form = ActiveForm::begin()?>
           <div>
                   <?= $form->field($model, 'q')->textInput(['class' =>'input', 'label' => '']);?>
                    <input type="image" src="/web/images/button_search.png" alt="Поиск" />
                </div>
            <?php $form = ActiveForm::end()?>
        </div>
        <div class="clear"></div>
    </div>

    <div id = "left">
        <div id = "content">
            <?=$content?>
        </div>
    </div>


        <div id="right">
<?php if($action == "index") { ?>
            <div id="author">
                <h4>Автор блога</h4>
                <img src="/web/images/author.png" alt="Михаил Русаков" />
                <p>Михаил Русаков</p>
                <a  href="<?=Yii::$app->urlManager->createUrl(['site/author'])?>">СТРАНИЦА АВТОРА</a>
            </div>
    <?php } else{ ?>
                <h2> Другие записи</h2>
    <?php if($action == 'post'){$post_id = Yii::$app->getRequest()->getQueryParam('id');} else{$post_id = null;}?>
    <?=PostOthers::widget(['id' => $post_id])?>
    <?php } ?>
            <div class="courses" id="courses">
                <div class="course">
                    <h4>Программирование на JavaScript для начинающих 2.0</h4>
                    <img src="/images/courses/freejavascript2.png" alt="Программирование на JavaScript для начинающих 2.0" />
                    <p class="more">
                        <a target="_blank" href="https://srs.myrusakov.ru/freejavascript2?utm_source=Blog.MyRusakov.ru&amp;utm_campaign=freejavascript2">ПОЛУЧИТЬ БЕСПЛАТНО</a>
                    </p>
                </div>


        </div>
        <div class="clear"></div>
    </div>
    <footer>
        <p>
            <img src="/web/images/footer.png" alt="" />
        </p>
        <p>

            <a href="/"><span>блог Михаила Русакова</span></a>
        </p>
  p      <ul class="menu">
            <li>
                <a href="/author.html">Об авторе</a>
            </li>
            <li>
                <a href="/courses.html">Видеокурсы</a>
            </li>
            <li>
                <a href="/reviews.html">Отзывы</a>
            </li>
            <li>
                <a href="/subscribe.html">Выпуски рассылки</a>
            </li>
            <li>
                <a target="_blank" href="https://myrusakov.ru">Мой сайт</a>
            </li>
            <li>
                <a href="/sites.html">Сайты учеников</a>
            </li>
        </ul>
        <div class="clear">

        </div>
        <div id="copy">
            <p>&copy; Blog.MyRusakov.ru <?=date("Y")?> г.</p>
            <p>ВСЕ ПРАВА ЗАЩИЩЕНЫ.</p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>