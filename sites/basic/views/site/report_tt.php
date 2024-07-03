<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      Создание  ФОТ :
    </p>





<?= Html::beginForm([''], 'get', ['enctype' => 'multipart/form-data', 'id' =>'fot_report_form']) ?>



<?= Html::radioList('report', 0, [ 0 =>'FOT', 1=>'TASKS']) ?>





<?= Html::label('Период  с :', 'date_from', ['class' => 'label date_from', 'required'=>'required']) ?>
<?= Html::input('date', 'date_from') ?>

<?= Html::label('Период  по :', 'date_to', ['class' => 'label date_to', 'required'=>true]) ?>
<?= Html::input('date', 'date_to') ?>

<?= Html::submitButton('Submit', ['class' => 'submit_report']) ?>
<?= Html::endForm() ?>

<? if(isset($error)) :?>

  <div class="alert alert-danger" role="alert">
  <?= $error; ?>
</div>

<? endif; ?>


<?
   echo "<pre>";
   print_r($array2);
   echo "</pre>";

?>

/////////////////////////////////////////////////////

<?
   echo "<pre>";
   print_r($array3);
   echo "</pre>";

?>





</div>