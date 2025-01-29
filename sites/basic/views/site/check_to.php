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

	    <div>
	    	   <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table5')"  value="Скачать....в EXEL">
	    </div>
		<div  id="table-conatainer">  
			<table  class="table" id ="Fot_table5">
			        <tr>
							    <th  scope="col">№</th>
							    <th  scope="col">ID заявки</th>
							    <th  scope="col">Статус</th>
							    <th  scope="col">Наименование</th>
							    <th  scope="col">Тип заявки</th>
							    <th  scope="col"   style="border: 1px solid;" >Запись выполненныз работ из журнала</th>
							    <th  scope="col"   style="border: 1px solid;">Акт выполненных работ</th>

							    
							    
							    <th  scope="col">Создана</th>
							    <th  scope="col">Закрыта</th>
			  
			        </tr> 
                <? $i=1;?>
			    <? foreach ($array as $key => $value) :?>
			    
			     <? if(in_array($value['StatusId'], [28,29])  && in_array($value['TypeId'], [5,1011])) : ?>
			      
			        <tr>
			     
			          <td><?=$i;?><? $i++;?> </td>

			          <td><a href="https://intraservice.ugmk-telecom.ru/Task/view/<?=$value['Id'];?>"><?=$value['Id'];?></a></td>
			          <td>
			            <? $s='';
			                if($value['StatusId'] == 28){ 
			                    $s ='Закрыта'; 
			                }
			                elseif ($value['StatusId'] == 29) {
			                    $s = 'Выполнена';
			                }
			                else $s = $value['StatusId'];
			                
			            ?>
			            <?=$s;?>
			          </td>
			          <td><?=$value['Name'];?></td>
			          <td><?=$value['Type'];?></td>
			          <? if($value['TypeId'] == 5) :?>
			            <? $jour = '_'; ?> 

			            <? foreach ($value['data2'] as $k => $val) :?>
			                <?if( $val[0] == 'id="1380"') :?>
			                  <? if($val[1]  !=='') :?>
			                      <? $jour = $val[1]; ?>
			                  <? endif;?>
			      
			                <? endif; ?>
			            <?  endforeach;?>
			             <td class="journal"  style="border: 1px solid;"><?= $jour;?></td>
			             <td class="akt" style="border: 1px solid;">_</td>
			            

			          <? else : ?>
			            <? $jourX = '_'; ?> 
			            <? $akt = '_'; ?>
			            <? foreach ($value['data2'] as $k => $val) :?>
			                <?if( $val[0] == 'id="1370"') :?>
			                  <? if($val[1]  !=='') :?>
			                     <? $jourX = $val[1]; ?>
			                  <? endif;?>    
			                <? endif; ?>
			                <?if( $val[0] == 'id="1381"') :?>
			                  <? if($val[1] !== '') :?>
			                   <? $akt =  $val[1]; ?></td>
			                  <? endif;?>
			                <? endif; ?>
			            <?  endforeach;?>
			            <td class="journal"><?= $jourX;?></td>
			             <td class="akt"><?= $akt;?></td>

			          <? endif; ?> 

			          <td><?=strstr($value['Created'], 'T', true);;?></td> 

			          <td><?= $value['Closed'] ? strstr($value['Closed'], 'T', true) : "-";?></td> 
			          
			         


			        </tr>
			     
			     <? endif; ?>
			     
			    <? endforeach; ?>
			</table> 
		</div>	   
	<? endif;?>


</div>