<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ServiceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="services-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'SERV_ID') ?>

    <?= $form->field($model, 'CODE') ?>

    <?= $form->field($model, 'NAME') ?>

    <?= $form->field($model, 'DESCRIPTION') ?>

    <?= $form->field($model, 'isArchiv') ?>

    <?php // echo $form->field($model, 'isPublic') ?>

    <?php // echo $form->field($model, 'ParentId') ?>

    <?php // echo $form->field($model, 'Path') ?>

    <?php // echo $form->field($model, 'GUID') ?>

    <?php // echo $form->field($model, 'Attribut_dogovor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
