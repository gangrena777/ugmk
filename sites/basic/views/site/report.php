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
<? //echo "<pre>";  print_r($array); echo "</pre>"; ?>

  <div>
    <h3>Выборка за период : <?= $data_str; ?></h3>
  </div>

  <div>
     <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table')"  value="Скачать....в EXEL">
  </div>
<div  id="table-conatainer">  
<table  class="table" id ="Fot_table">
  <tr>
    <th  scope="col">Исполнитель</th>
    <th  scope="col">Название НГ</th>
    <th  scope="col">Код НГ</th>
    <th  scope="col">Назначение использования ТМЦ</th>
    <th  scope="col">Назнание участка</th>
    <th  scope="col">Доля трудозатрат</th>
    <th>Трудозатраты на НГ</th>
  </tr> 

<? foreach($array as $key =>$value)  :?>
  <? foreach ($value as $k => $val) :?>

    

        <tr  scope="row">
          <td><?= $key; ?></td>
          

            <td><?= $k; ?></td> 
              <td><?= $value[$k]['Код НГ'] ?></td> 
                <td><?= $value[$k]['Назначение ТМЦ'] ?></td> 
                  <td><?= $value[$k]['Участок']."/".$value[$k]['Участок__'] ?></td> 
                     <td><?= str_replace('.', ',' , strval((round($value[$k]['OBJ_SUM']/$value[$k]['TOTAL'] *100,2)))); ?></td> 
                     <td><?=str_replace('.', ',',strval($value[$k]['OBJ_SUM']));?></td>
        </tr>
  <?  endforeach;  ?>
<?   endforeach;  ?>
</table>
</div>
<? endif; ?>
</div>