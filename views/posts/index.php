<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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

            //'full_text:ntext',
            //'date',
            //'meta_desc',
            //'meta_key',
            //'hits',
            //'hide',
            //'no_form',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
