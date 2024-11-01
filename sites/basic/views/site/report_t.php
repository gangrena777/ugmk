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

<?= Html::radioList('report', 1, [ 0 =>'ФОТ', 1=>'Отчет за период']) ?>

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
      <? // echo "<pre>";  print_r($array); echo "</pre>"; ?>

       <div  style ="display: flex; flex-wrap: wrap;">
          
            <? $TOTAL_TOTAL = 0;  ?>
            <? $TOTAL_TOTAL_COUNT = 0; ?>
            <? foreach ($array3 as $key => $value)  :?>   <!---  region-->
               <?  $TOTAL_SUM = 0; 
                   $TOTAL_COUNT = 0;

               ?>
             <div  style =" width: 30%; border: 2px solid  black; margin: 3px 3px; padding: 3px 3px;">
             <h5><?=$key; ?></h5>
                  <? foreach ($value as $k => $val) :?> <!-- task type  -->
                      <? $type_sum = 0; ?>

                           <h6><?= preg_replace('/<[^>]*>/', ' ',preg_replace("/[a-zA-Z]/", " ", $k));;?></h6>

                       <?  foreach ($val as $i => $vvv)  :?> <!---  task  -->
                             <? $task_sum = 0;  ?>

                            <? foreach ($vvv as $z => $v)  :?> <!--- taskexe -->
                                 <?  $task_sum += $v['ЧЧ']; ?>
                            <? endforeach; ?> <!--- /taskexe -->
                            

                           <? $type_sum += $task_sum;?>

                       <? endforeach; ?><!---  /task  -->
                       <? $type_task_count = count($val);?>
                       <p>Кол-во  заявок  - <?=$type_task_count ?></p>
                       <p>Кол-во  часов по типу  - <?=$type_sum; ?></p>
                    <? $TOTAL_SUM += $type_sum; ?>
                    <? $TOTAL_COUNT += $type_task_count; ?>
                  

                  <?  endforeach;  ?><!-- /task type  -->
                  <h6>КОЛ-ВО ЗАЯВОК ПО УЧАСТКУ : <?= $TOTAL_COUNT; ?></h6>
                  <h6>СУММА ЧАСОВ ПО УЧАСТКУ : <?= $TOTAL_SUM; ?></h6>
                  <? $TOTAL_TOTAL += $TOTAL_SUM; ?>
                  <? $TOTAL_TOTAL_COUNT += $TOTAL_COUNT; ?>
              </div>       
            <? endforeach;?><!---  /region-->

            <div style =" width: 30%; border: 2px solid  black; margin: 3px 3px; padding: 3px 3px; background:red;">
                <div style="font-size: 16px;font-weight: bold;">Общее кол-во заявок за период по всем участкам : <?=$TOTAL_TOTAL_COUNT;?></div>
                <div style="font-size: 16px;font-weight: bold;">Общая сумма часов за период по всем участкам:  <?=$TOTAL_TOTAL; ?></div>
            </div>
           
       </div>



      <div  style="margin: 20px 0;">
           <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table2')"  value="Скачать....в EXEL">
      </div>
      <div  id="table-conatainer">  
          <table  class="table" id ="Fot_table2">
                  <tr>
                      <th  scope="col">№</th>
                      <th scope="col">Исполнитель</th>
                      <th  scope="col">Дата трудозатрат</th>
                      <th  scope="col">Статус</th>
                      <th  scope="col">Номер заявки</th>
                       <th  scope="col">Тип заявки</th>

                      <th  scope="col">Наименование заявки</th>
                      <th  scope="col">Код сервиса</th>
                      <th  scope="col">ID сервиса</th>
                      <th  scope="col">Назнание участка</th>
                      <th  scope="col">Трудозатраты в часах</th>
                       <th  scope="col">Трудозатраты (number)</th>
                      <th  scope="col">Комментарий</th>
                       <th  scope="col">dogovor_code</th>
                       <th  scope="col">Attribut_dogovor(Номер договора)</th>
                        <th  scope="col">dogovor_name(Название договора)</th>

                  
                  </tr> 

              <? foreach($array as $key =>$value)  :?>
                  <tr  scope="row">
                        <td><?= $key +1; ?></td>
                          <td><?= $value['Исполнитель']; ?></td>
                        <td><?= $value['Дата трудозатрат']; ?></td> 
                            <? 
                              $s='';
                              if($value['Статус'] == '28'){ 
                                 $s ='Закрыта'; 
                              }
                              elseif ($value['Статус'] == '29') {
                                    $s = 'Выполнена';
                              }
                              elseif($value['Статус'] == '27'){
                                  $s = 'В работе';
                              }elseif($value['Статус'] == '26'){
                                   $s = 'Отложена';
                              }
                              elseif($value['Статус'] == '30'){
                                   $s = 'Отменена';
                              }
                              elseif($value['Статус'] == '31'){
                                   $s = 'Открыта';
                              }
                              else $s = $value['Статус'];
                            ?>

                            <td><?= $s; ?></td> 
                              <td><?= $value['№ заявки'] ?></td> 
                                 <td><?= preg_replace('/<[^>]*>/', ' ',preg_replace("/[a-zA-Z]/", " ", $value['Тип']));?></td> 

                                <td><?= $value['Наименование заявки'] ?></td> 
                                   <td><?= $value['Код сервиса']  ?></td> 
                                      <td><?=$value['Индефикатор сервиса'] ?></td>
                                        
                                            <td><? if(isset($value['Участок__']) )  echo  $value['Участок__']; else echo  "_____"; ?></td>
                                            	 <td><?=$value['Трудозатраты(часы)'] ?></td>
                                               <?
                                                   list($hours, $minutes) = explode(":", $value['Трудозатраты(часы)']);

        
                                                   $decimalTime = $hours + ($minutes / 60);
                                                   //$num = str_replace('.', ',',strval(round($decimalTime,2)));

                                                   $num = str_replace('.', ',' , strval((round($decimalTime,2))));



                                               ?>
                                               <td><?=$num; ?></td>
                                                <td><?=$value['Комментарий'] ?></td>
                                                 <td><? if(isset($value['Д.Code'])) echo $value['Д.Code']; else echo "____"; ?></td>
                                                  <td><? if(isset($value['Attribut_dogovor'])) echo $value['Attribut_dogovor']; else "____"; ?></td>
                                                      <td><? if(isset($value['dogovor_name'])) echo $value['dogovor_name']; else "____"; ?></td>

                  </tr>

              <?   endforeach;  ?>
          </table>
      </div>
<? endif; ?>


</div>