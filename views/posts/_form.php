<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if($model->img) { ?>
    <div class = "img">
       <img src="<?= Yii::getAlias('@web/uploads' ).'/'.$model->img?>" width="300" height="250">
    </div>
    <?php }?>

    <?php
    $fileField = $form->field($model, 'imageFile');
    $fileField->enableClientValidation = false;
    echo $fileField->fileInput();
    ?>

    <?= $form->field($model, 'intro_text')->widget(Redactor::className())  ?>

    <?= $form->field($model, 'full_text')->widget(Redactor::className())  ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
