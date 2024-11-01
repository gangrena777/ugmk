<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'check To';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>




<?//= Html::beginForm([''], 'get', ['enctype' => 'multipart/form-data', 'id' =>'fot_report_form2']) ?>
<?//= //Html::radioList('report', 2, [ 0 =>'ФОТ', 1=>'Отчет за период']) ?>
<?//= Html::label('Период  с :', 'date_from', ['class' => 'label date_from', 'required'=>'required']) ?>
<?//= Html::input('date', 'date_from') ?>

<?//= Html::label('Период  по :', 'date_to', ['class' => 'label date_to', 'required'=>true]) ?>
<?//= Html::input('date', 'date_to') ?>

<?//= Html::submitButton('Submit', ['class' => 'submit_report']) ?>
<?//= Html::endForm() ?>



 <?//php $form = ActiveForm::begin([
         //   'options' => ['enctype' => 'multipart/form-data', 'id' => 'upload-form'],
           
    //    ]); ?>


        <?//= Html::label('Участок :', 'list', ['class' => 'label date_from']) ?>
        <?///= Html::dropDownList('list', null, $regions) ?>


        <?//= Html::label('Период  с :', 'date_from', ['class' => 'label date_from', 'required'=>'required']) ?>
        <?//= Html::input('date', 'date_from') ?>

        <?//= Html::label('Период  по :', 'date_to', ['class' => 'label date_to', 'required'=>true]) ?>
        <?//= Html::input('date', 'date_to') ?>


        
        <?//= Html::submitButton('Upload and Process', ['class' => 'btn btn-primary']) ?>

<?//php ActiveForm::end(); ?>

<?= Html::beginForm([''], 'get', ['enctype' => 'multipart/form-data', 'id' =>'fot_report_form']) ?>

<?= Html::label('Участок :', 'region', ['class' => 'label date_from']) ?>
<?= Html::dropDownList('region', null, $regions,[ 'prompt' => 'Select region']) ?>

<?= Html::label('Период  с :', 'date_from', ['class' => 'label date_from', 'required'=>'required']) ?>
<?= Html::input('date', 'date_from') ?>

<?= Html::label('Период  по :', 'date_to', ['class' => 'label date_to', 'required'=>true]) ?>
<?= Html::input('date', 'date_to') ?>

<?= Html::submitButton('Submit', ['class' => 'submit_report']) ?>
<?= Html::endForm() ?>




<? if(isset($error)) :?>

  <div class="alert alert-danger" role="alert">
      <?  var_dump($error); ?>
  </div>

<? endif; ?>




<? if( isset($data_str) && $data_str !== '') :?>
        <div>
          <h3>Выборка   по : <?= $current_reg ;?> за период: <?= $data_str; ?></h3>
        </div>
  <? //echo  "<pre>";  print_r($array); echo "</pre>"; ?>

<? endif;?>



<p>++++++++++++++++++++++++++++++++++++++++++++++</p>

<? if(isset($array)) :?>

	 <? foreach ($array as $key => $value) :?>

    <pre>
      <? print_r($value); ?>
    </pre>

   <? endforeach; ?>
<? endif;?>


</div>