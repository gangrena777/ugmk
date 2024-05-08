<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Dogovor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dogovor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONTRAGENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GUID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ATTRIBUT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERIOD')->textInput() ?>

    <?= $form->field($model, 'REGION_ID')->textInput() ?>

    <?= $form->field($model, 'NAME_NG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CODE_NG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'USE_TMC')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
