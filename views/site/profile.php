<?php

use app\models\Posts;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

/** @var app\models\Users $user */
/** @var app\models\Posts $dataProvider */


$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col border">
            <div class="col-4-xs">
                <?= $user->first_name . " " . $user->last_name ?>
            </div>
            <div class="img">
                <?php if ($user->img == null) {
                    echo Html::img('/uploads/users/default_avatar.png', $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                } else {
                    echo Html::img('/uploads/users/' . $user->img, $options = ['class' => 'postImg', 'style' => ['width' => '180px']]);
                } ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col border">

            <h2>My <?= $this->title ?></h2>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [

                    'id',
                    [
                        'attribute' => 'is_release',
                        'label' => 'is_release',
                        'filter' => [0 => 'No', 1 => 'Yes'],
                        'value' =>
                            function ($model) {
                                if ($model->is_release == 1) {
                                    $model->is_release = 'yes';
                                } elseif ($model->is_release == 0) {
                                    $model->is_release = 'No';
                                }
                                return $model->is_release;
                            }],
                    'title',

                    ['class' => 'yii\grid\ActionColumn',
                       'controller' => 'posts',

                        ],
                ],
            ]); ?>
            <p>
                <a href=" <?= Url::to(['posts/create']) ?>" class='btn btn-success'>Create Posts</a>

            </p>
        </div>

    </div>

</div>


<style>
    .border
    {
        border:1px solid black;
        background: #f5f5f5;
    }
</style>
