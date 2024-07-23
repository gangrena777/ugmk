<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
<p  class="alert alert-info"><small>В отчет за период попадают заявки со статусом : в работе, закрыта, выполнена.</small></p>    


<?= Html::beginForm([''], 'get', ['enctype' => 'multipart/form-data', 'id' =>'fot_report_form']) ?>
<?= Html::radioList('report', 0, [ 0 =>'ФОТ', 1=>'ОТЧЕТ ЗА ПЕРИОД']) ?>
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



<?  if(isset($array)) :?>

        <div>
          <h3>Выборка за период : <?= $data_str; ?></h3>
        </div>
      <? echo "<pre>";  print_r($array); echo "</pre>"; ?>





<? endif; ?>


</div>