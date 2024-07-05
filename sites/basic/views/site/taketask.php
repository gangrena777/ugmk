<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Reports2';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

        <h1><?= Html::encode($this->title) ?></h1>
        <p  class="alert alert-info"><small>Посмотреть  заявки  созданные за период</small></p>



        <?= Html::beginForm([''], 'get', ['enctype' => 'multipart/form-data', 'id' =>'fot_report_form']) ?>
        <?= Html::label('Период  с :', 'date_from', ['class' => 'label date_from', 'required'=>'required']) ?>
        <?= Html::input('date', 'date_from') ?>

        <?= Html::label('Период  по :', 'date_to', ['class' => 'label date_to', 'required'=>true]) ?>
        <?= Html::input('date', 'date_to') ?>

        <?= Html::submitButton('Submit', ['class' => 'submit_report']) ?>
        <?= Html::endForm() ?>

        <? if(isset($error)) :?>
              <div class="alert alert-danger" role="alert"><?= $error; ?></div>
        <? endif; ?>

        <?  if(isset($array)) :?>
               <? //echo "<pre>";  print_r($array); echo "</pre>"; ?>

              <div>
                <h3>Выборка заявок созданных за период : <?= $data_str; ?></h3>
              </div>
              <div  style ="display: flex; flex-wrap: wrap;">
                  <? 
                     $TOTAL_TOTAL = 0; 
                     $TOTAL_STATUS = array(); ?>

                  
                        <? foreach ($array as $key => $value)  :?>   <!---  region-->
                            <? $TOTAL = 0;?>
                            <div  style =" width: 30%; border: 2px solid  black; margin: 3px 3px; padding: 3px 3px;">
                            <h5><?=$key; ?></h5>
                              <? foreach ($value as $k => $val) :?>    <!--- type     -->
                                <? $type_count = 0; ?>
                                <h6><?= preg_replace('/<[^>]*>/', ' ',preg_replace("/[a-zA-Z]/", " ", $k));;?></h6>
                                <ul>
                                     <? foreach ($val as $i => $v) :?>     <!---  status  -->
                                          <? $st= array(); ?>
                                          <? $status_count = count($v);?>
                                            <li><?= preg_replace('/<[^>]*>/', ' ',preg_replace("/[a-zA-Z]/", " ", $i));?>  -  <?=$status_count;?></li>
                                              <?   $type_count += $status_count; ?>
                                              <? $st[$i] = $status_count; ?>
                                              <?  $TOTAL_STATUS[] = $st; ?>
                                     <? endforeach; ?>
                                
                                </ul>

                                 <?//= $type_count; ?>
                                 <? $TOTAL += $type_count; ?>
                             
                              <? endforeach; ?>
                            <strong>ОБЩЕЕ КОЛ-ВО ЗАЯВОК НА УЧАСТКЕ: <?=$TOTAL;?></strong>
                            
                             
                            </div>
                             <? $TOTAL_TOTAL += $TOTAL; ?>
                        <? endforeach;?>

                    <div  style =" width: 30%; border: 2px solid  black; margin: 3px 3px; padding: 3px 3px; background:red; ">
                          <h5>ВСЕГО ЗАЯВОК ЗА ПЕРИОД : <?=$TOTAL_TOTAL; ?></h5>

                          <? 
                              foreach ($TOTAL_STATUS as $entry){
                                      foreach ($entry as $status => $count){
                                         
                                          if (!isset($statusCounts[$status])){
                                              $statusCounts[$status] = 0;
                                          } 
                                          $statusCounts[$status] += $count;
                                      }
                              }
                          ?>

                           
                           <div>
                             <ul>
                          <?    
                             foreach ($statusCounts as $status => $count):?>
                               <li><?= preg_replace('/<[^>]*>/', ' ',preg_replace("/[a-zA-Z]/", " ", $status));?>  -- <?=$count; ?></li>  
                          <? endforeach; ?>
                           </ul>
                          </div>
                    </div>

              </div>

           
                      <? //echo "<pre>"; print_r(($TOTAL_STATUS)); echo "</pre>"; ?>
        <? endif; ?>


</div>