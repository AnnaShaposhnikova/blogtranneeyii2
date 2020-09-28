<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'is_release',
                'label' => 'is_release',
                'filter'=>[0 => 'No', 1 => 'Yes'],
                'value' =>
                    function ($model) {
                        if ($model->is_release == 1) {
                            $model->is_release = 'yes';
                        } elseif ($model->is_release == 0) {
                            $model->is_release = 'No';
                        }
                        return $model->is_release;
                    }
            ],

            'title',
            'img',
            'intro_text:ntext',
            'full_text:ntext',
            'date',
        ],
    ]) ?>

</div>
