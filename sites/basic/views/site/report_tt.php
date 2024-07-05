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
   print_r($array3);
   echo "</pre>";

?>

/////////////////////////////////////////////////////

<div  style ="display: flex; flex-wrap: wrap;">
    

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
            <p>СУММА ЗАЯВОК ПО УЧАСТКУ : <?= $TOTAL_COUNT; ?></p>
            <p>СУММА ЧАСОВ ПО УЧАСТКУ : <?= $TOTAL_SUM; ?></p>

        </div>       
      <? endforeach;?><!---  /region-->

 </div>




</div>