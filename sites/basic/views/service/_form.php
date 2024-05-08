<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Services $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SERV_ID')->textInput() ?>

    <?= $form->field($model, 'CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESCRIPTION')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isArchiv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isPublic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ParentId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GUID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Attribut_dogovor')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
