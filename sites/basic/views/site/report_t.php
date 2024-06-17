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
<?  if(isset($array)) :?>


  <div>
    <h3>Выборка за период : <?= $data_str; ?></h3>
  </div>
<?// echo "<pre>";  print_r($array); echo "</pre>"; ?>



 <div>
    <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table2')"  value="Скачать....в EXEL">
 </div>
<div  id="table-conatainer">  
<table  class="table" id ="Fot_table2">
  <tr>
    <th  scope="col">№</th>
    <th  scope="col">Дата трудозатрат</th>
    <th  scope="col">Статус</th>
    <th  scope="col">Номер заявки</th>
     <th  scope="col">Тип заявки</th>

    <th  scope="col">Наименование заявки</th>
    <th  scope="col">Код сервиса</th>
    <th  scope="col">ID сервиса</th>
    <th  scope="col">Назнание участка</th>
    <th  scope="col">Трудозатраты в часах</th>
  
  </tr> 

<? foreach($array as $key =>$value)  :?>
    <tr  scope="row">
          <td><?= $key; ?></td>
            <td><?= $value['Дата трудозатрат']; ?></td> 
              <td><?= $value['Статус'] == 28 ? 'Закрыта' : 'Выполнена' ?></td> 
                <td><?= $value['№ заявки'] ?></td> 
                   <td><?= preg_replace('/<[^>]*>/', ' ',preg_replace("/[a-zA-Z]/", " ", $value['Тип']));?></td> 

                  <td><?= $value['Наименование заявки'] ?></td> 
                     <td><?= $value['Код сервиса']  ?></td> 
                        <td><?=$value['Индефикатор сервиса'] ?></td>
                          
                              <td><?=$value['Участок__'] ?></td>
                              	 <td><?=$value['Трудозатраты(часы)'] ?></td>
    </tr>

<?   endforeach;  ?>
</table>
</div>
<? endif; ?>


</div>