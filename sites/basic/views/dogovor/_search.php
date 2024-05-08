<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\DogovorSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dogovor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CODE') ?>

    <?= $form->field($model, 'CONTRAGENT') ?>

    <?= $form->field($model, 'GUID') ?>

    <?= $form->field($model, 'ATTRIBUT') ?>

    <?php // echo $form->field($model, 'PLAN') ?>

    <?php // echo $form->field($model, 'PERIOD') ?>

    <?php  echo $form->field($model, 'REGION_ID') ?>

    <?php // echo $form->field($model, 'NAME_NG') ?>

    <?php // echo $form->field($model, 'CODE_NG') ?>

    <?php // echo $form->field($model, 'USE_TMC') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
