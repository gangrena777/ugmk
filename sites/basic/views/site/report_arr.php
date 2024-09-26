<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Analize Rent Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>



 <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'id' => 'upload-form'],
            'action' => ['site/upload']
        ]); ?>

        <?= Html::label('Выбирите папку или файлы для загрузки:', 'files') ?>
        <?= Html::fileInput('files[]', null, ['multiple' => true, 'id' => 'files', 'webkitdirectory' => true, 'directory' => true]) ?>


        <?= Html::label('Период  с :', 'date_from', ['class' => 'label date_from', 'required'=>'required']) ?>
        <?= Html::input('date', 'date_from') ?>

        <?= Html::label('Период  по :', 'date_to', ['class' => 'label date_to', 'required'=>true]) ?>
        <?= Html::input('date', 'date_to') ?>


        
        <?= Html::submitButton('Upload and Process', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>

      <script>
            document.getElementById('files').addEventListener('change', function(event) {
                const files = event.target.files;
                let folderName = '';
                if (files.length > 0) {
                    const fullPath = files[0].webkitRelativePath;
                    const pathParts = fullPath.split('/');
                    folderName = pathParts[0];
                }
                document.getElementById('upload-form').action = `planerenttask`;
            });
        </script>


<? if(isset($error)) :?>

  <div class="alert alert-danger" role="alert">
      <?  foreach($error as $er =>$val) :?>
      	<p><?= $val; ?></p>
      <? endforeach; ?>
  </div>

<? endif; ?>



<?  if(isset($array2)) :?>

        <div>
          <h3>Выборка за период : <?= $data_str; ?></h3>
        </div>
	    <? //echo  "<pre>";  print_r($array); echo "</pre>"; ?>

	    <? $i = 1; ?>

		<div  style ="display: flex; flex-wrap: wrap;">
		    <? foreach ($array2 as $key => $region) :?>
		  
		          <ul   style =" width: 30%; border: 2px solid  black; margin: 3px 3px; padding: 3px 30px;">
		            <div  style="font-size: 18px;  font-weight: bold;"><?= $key;?></div>
		             <? 
		                $total_plan = 0;
		                $total_fakt = 0;
		                $total_work = 0;
		                $total_adm  = 0;
		                $total_log  = 0;
		                $total_no   = 0;

		                foreach($region as $k => $contract) {
		                       if(isset($contract['PLAN_ЧЧ'])){

		                             $total_plan += $contract['PLAN_ЧЧ'];
		                        }

		                        if(isset($contract['FAKT_ЧЧ'])){

		                             $total_fakt += $contract['FAKT_ЧЧ'];
		                        }

		                        if(isset($contract['раб']['FAKT_ЧЧ'])){

		                             $total_work += $contract['раб']['FAKT_ЧЧ'];
		                        }
		                          if(isset($contract['лог']['FAKT_ЧЧ'])){

		                             $total_log += $contract['лог']['FAKT_ЧЧ'];
		                        }
		                          if(isset($contract['адм']['FAKT_ЧЧ'])){

		                             $total_adm += $contract['адм']['FAKT_ЧЧ'];
		                        }
		                          if(isset($contract['']['FAKT_ЧЧ'])){

		                             $total_no += $contract['']['FAKT_ЧЧ'];
		                        }

		                }
		              ?>

		                <li style=" list-style-type: none;">ВСЕГО ПО ПЛАНУ ТО  - <?= $total_plan; ?></li>
		                <li style=" list-style-type: none;">ВСЕГО ПО ФАКТУ  - <?= $total_fakt; ?></li>
		                <li>всего Раб  - <?= $total_work + $total_no; ?></li>
		                <li>всего Адм  - <?= $total_adm; ?></li>
		                <li>всего Лог  - <?= $total_log; ?></li>
		              <!--   <li>всего ?  - <?//= $total_no; ?></li> -->

		          </ul>  
		       
		    <? endforeach; ?>
		</div> 







        <div>
            <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table3')"  value="Скачать....в EXEL">
        </div>

	    <table  class="table" id ="Fot_table3">
	                  <tr>
	                      <th  scope="col">№</th>
	                      <th  scope="col">Участок</th>
	                      <th  scope="col">Договор</th>

	                      <th  scope="col">Контрагент</th>
	                      <th  scope="col">План в договоре</th>

	                      <th  scope="col">План ТО</th>
	                      <th  scope="col">Факт общий</th>
	                      <th  scope="col"  style="color:green">ФАКТ РАБ</th>
	                         <th  scope="col" style="color:green">Факт раб   ТО</th>
	                         <th  scope="col" style="color:green">Факт раб   Инц</th>
	                         <th  scope="col" style="color:green">Факт раб   Зап</th>


	                      <th  scope="col" style="color:orange">ФАКТ ЛОГ</th>
	                          <th  scope="col" style="color:orange">Факт лог   ТО</th>
	                          <th  scope="col" style="color:orange">Факт лог   Инц</th>
	                          <th  scope="col" style="color:orange">Факт лог   Зап</th>
	                      <th  scope="col" style="color: blue">ФАКТ АДМ</th>
	                         <th  scope="col" style="color: blue">Факт адм   ТО</th>
	                         <th  scope="col" style="color: blue">Факт адм   Инц</th>
	                         <th  scope="col" style="color: blue">Факт адм   Зап</th>
	                  <!--     <th  scope="col">Факт ?</th> -->

	                  </tr> 
	    
	      <? $i = 1; ?>
	      <? foreach ($array2 as $key => $region) :?>

	      	    <? foreach($region as $k => $contract)  :?>

	      	    	        <tr>
	                           <td><?= $i++;?></td>
	          	      	  	   <td><?= $key;?></td>
	          	      	  	   <td><?= $k; ?></td>

	                           <td><? if(isset($contract['Contragent'])) echo  $contract['Contragent']; else echo "_"; ?></td>
	                           <td><? if(isset($contract['DPlan'])) echo  $contract['DPlan']; else echo "_"; ?></td>

	                          
	          	      	  	   <td><? if(isset($contract['PLAN_ЧЧ'])) echo str_replace('.', ',' , strval((round($contract['PLAN_ЧЧ'],2))));  else  echo "0"; ?></td>
	          	      	  	   <td style="font-weight: 900;"><? if(isset($contract['FAKT_ЧЧ'])) echo str_replace('.', ',' , strval((round($contract['FAKT_ЧЧ'],2))));  else  echo "0"; ?></td>
	                           <? if(isset($contract['раб']['FAKT_ЧЧ'])) $work1 = $contract['раб']['FAKT_ЧЧ']; else $work1 = 0; ?>
	                           <? if(isset($contract['']['FAKT_ЧЧ'])) $work2 =  $contract['']['FAKT_ЧЧ']; else $work2 = 0; ?>
	                           <?  $work = $work1 + $work2; ?>
	                           <!--  раб -->
	                           <td style="color:green;  font-weight: 900;"><?= str_replace('.', ',' , strval((round($work,2)))); ?></td>
	                            <? if(isset($contract['раб'])) :?>
	                                  <? $total = 0;?>
	                                  <? foreach ($contract['раб']['TYPE'] as $k => $val):?>
	                                      <? if(str_contains($k, 'Плановое') || str_contains($k, 'Журнал')) $total += $val;  ?> 
	                                  <? endforeach; ?>
	                                  <td  style="color:green"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color:green">0</td>   
	                            <? endif; ?>      


	                            <? if(isset($contract['раб'])) :?>
	                                <? $total = 0;?>
	                                <? foreach ($contract['раб']['TYPE'] as $k => $val):?>
	                                    <?  if(str_contains($k, 'Инцидент')) $total += $val;?>
	                                <? endforeach; ?>
	                                <td  style="color:green"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color:green">0</td>      
	                            <? endif; ?>
	                            

	                            <? if(isset($contract['раб'])) :?>
	                               <? $total = 0;?>
	                               <? foreach ($contract['раб']['TYPE'] as $k => $val):?>
	                                   <?  if(str_contains($k, 'Запрос'))  $total += $val; ?>
	                               <? endforeach; ?> 

	                                <td  style="color:green"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color:green">0</td>  
	                            <? endif; ?>    

	                            
	                     
	                            <!-- /// раб -->

	                            <!--  лог -->
	                            <td  style="color:orange; font-weight: 900;">
	                              <? if(isset($contract['лог']['FAKT_ЧЧ'])) echo str_replace('.', ',' , strval((round($contract['лог']['FAKT_ЧЧ'],2)))); else echo "0";?>
	                            </td>
	                            <? if(isset($contract['лог'])) :?>
	                                  <? $total = 0;?>
	                                  <? foreach ($contract['лог']['TYPE'] as $k => $val):?>
	                                      <? if(str_contains($k, 'Плановое') || str_contains($k, 'Журнал')) $total += $val; ?>
	                                  <? endforeach; ?>
	                                  <td  style="color:orange;"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color:orange;">0</td>  
	                            <? endif; ?>      


	                            <? if(isset($contract['лог'])) :?>
	                                <? $total = 0;?>
	                                <? foreach ($contract['лог']['TYPE'] as $k => $val):?>
	                                    <?  if(str_contains($k, 'Инцидент')) $total += $val;?>
	                                <? endforeach; ?>
	                                <td  style="color:orange;"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color:orange;">0</td>  
	                            <? endif; ?>
	                            

	                            <? if(isset($contract['лог'])) :?>
	                               <? $total = 0;?>
	                               <? foreach ($contract['лог']['TYPE'] as $k => $val):?>
	                                   <?  if(str_contains($k, 'Запрос'))  $total += $val; ?>
	                               <? endforeach; ?>  
	                                <td  style="color:orange;"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color:orange;">0</td>  
	                            <? endif; ?>  
	                       
	                           <!-- /// лог -->

	                           <!--  адм -->
	                           <td  style="color: blue; font-weight: 900;">
	                               <? if(isset($contract['адм']['FAKT_ЧЧ'])) echo str_replace('.', ',' , strval((round($contract['адм']['FAKT_ЧЧ'],2)))); else echo "0";?>
	                             
	                           </td>
	                            <? if(isset($contract['адм'])) :?>
	                                  <? $total = 0;?>
	                                  <? foreach ($contract['адм']['TYPE'] as $k => $val):?>
	                                      <? if(str_contains($k, 'Плановое')) $total += $val; ?>
	                                  <? endforeach; ?>
	                                  <td  style="color: blue"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color: blue">0</td>  
	                            <? endif; ?>      


	                            <? if(isset($contract['адм'])) :?>
	                                <? $total = 0;?>
	                                <? foreach ($contract['адм']['TYPE'] as $k => $val):?>
	                                    <?  if(str_contains($k, 'Инцидент')) $total += $val;?>
	                                <? endforeach; ?>
	                                <td  style="color: blue"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color: blue">0</td>  
	                            <? endif; ?>
	                            

	                            <? if(isset($contract['адм'])) :?>
	                               <? $total = 0;?>
	                               <? foreach ($contract['адм']['TYPE'] as $k => $val):?>
	                                   <?  if(str_contains($k, 'Запрос'))  $total += $val; ?>
	                               <? endforeach; ?>  
	                                <td  style="color: blue"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
	                            <? else: ?>
	                               <td  style="color: blue">0</td>  
	                            <? endif; ?>  
	                           
	                             <!-- /// адм -->
	                             <!--      <td><?// if(isset($contract['']['FAKT_ЧЧ'])) echo $contract['']['FAKT_ЧЧ']; else echo "0";?></td> -->
	                        </tr>

	      	     <? endforeach; ?>
	      	
	      <? endforeach;?>

	    </table>

<? endif; ?>

<p>+++++++++++++++++++++++++++++++++++++
</p>

<? if(isset($array)) :?>

	   <?// echo "<pre>";  print_r($array); echo "</pre>"; ?>

<? endif;?>

<? if(isset($arrayP)) :?>

	 

    <h4>Анализ в разрезе исполнителей......</h4>

	<div>
     <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table4')"  value="Скачать....в EXEL">
    </div>

        <table  class="table" id ="Fot_table4">
              <tr>
                  <th  scope="col">№</th>
                  <th  scope="col">Участок</th>
                  <th  scope="col">Договор</th>

                  <th  scope="col">Контрагент</th>
                  <th  scope="col">Исполнитель</th>

                 <th  scope="col">План ТО</th>
                  <th  scope="col">Факт общий</th>
                  <th  scope="col"  style="color:green">ФАКТ РАБ</th>
                     <th  scope="col" style="color:green">Факт раб   ТО</th>
                     <th  scope="col" style="color:green">Факт раб   Инц</th>
                     <th  scope="col" style="color:green">Факт раб   Зап</th>


                  <th  scope="col" style="color:orange">ФАКТ ЛОГ</th>
                      <th  scope="col" style="color:orange">Факт лог   ТО</th>
                      <th  scope="col" style="color:orange">Факт лог   Инц</th>
                      <th  scope="col" style="color:orange">Факт лог   Зап</th>
                  <th  scope="col" style="color: blue">ФАКТ АДМ</th>
                     <th  scope="col" style="color: blue">Факт адм   ТО</th>
                     <th  scope="col" style="color: blue">Факт адм   Инц</th>
                     <th  scope="col" style="color: blue">Факт адм   Зап</th>
                  <!--     <th  scope="col">Факт ?</th> -->

              </tr> 
		        <? $i = 1; ?>
		        <? foreach ($arrayP as $key => $region) :?>


		      	    <? foreach($region as $k => $contract)  :?> 

		      	    	<? foreach ($contract as $kk => $person) :?>

		      	    	    <? if($kk !=='Contragent' && $kk !=='DPlan' && $kk !=='PLAN_ЧЧ') :?>
		      	    	       <tr>
		      	    		    <td><?= $i++;?></td>
		          	      	  	<td><?= $key;?></td>
		          	      	  	<td><?= $k; ?></td>
		          	      	  	<td><? if(isset($contract['Contragent'])) echo  $contract['Contragent']; else echo "_"; ?></td>
		          	      	  
		          	      	  	<td><?= $kk; ?></td>
		          	      	    <td><? if(isset($contract['PLAN_ЧЧ'])) echo str_replace('.', ',' , strval((round($contract['PLAN_ЧЧ'],2))));  else  echo "0"; ?></td>
		          	            <td  style="font-weight: 900;">
		          	            	<? if(isset($person['PERSON_ЧЧ'])) echo  str_replace('.', ',' , strval((round($person['PERSON_ЧЧ'],2))));  else  echo "0"; ?>
		          	            		
		          	            </td>
		          	      
		                        
		                          <!-- раб --->
		                          <? if(isset($person['раб'])) :?>
		                                 <td  style="color:green;font-weight: 900;"><?= str_replace('.', ',' , strval((round($person['раб']['COM_ЧЧ'],2)))) ?></td>
		                          <? else : ?>
		                                 <td  style="color:green;font-weight: 900;">0</td>
		                          <? endif;?> 

		                         <? if(isset($person['раб'])) :?>
		                            <? $total = 0;?>
		                                <? foreach ($person['раб']['TYPES'] as $z => $val):?>
		                                      <? if(str_contains($z, 'Плановое') || str_contains($z, 'Журнал')) $total += $val;  ?> 
		                                <? endforeach; ?>
		                                <td  style="color:green"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                                <td  style="color:green">0</td>   
		                          <? endif; ?>  
		                        
		                          <? if(isset($person['раб'])) :?>
		                              <? $total = 0;?>
		                              <? foreach ($person['раб']['TYPES'] as $z => $val):?>
		                                    <?  if(str_contains($z, 'Инцидент')) $total += $val;?>
		                              <? endforeach; ?>
		                                <td  style="color:green"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                          <? else: ?>
		                               <td  style="color:green">0</td>      
		                          <? endif; ?>
		                            

		                          <? if(isset($person['раб'])) :?>
		                              <? $total = 0;?>
		                              <? foreach ($person['раб']['TYPES'] as $z => $val):?>
		                                <?  if(str_contains($z, 'Запрос'))  $total += $val; ?>
		                              <? endforeach; ?> 

		                                <td  style="color:green"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                          <? else: ?>
		                               <td  style="color:green">0</td>  
		                          <? endif; ?>  

		                          <!-- /////// раб --->


		          	              <!-- лог --->
		                          <? if(isset($person['лог'])) :?>
		                            <td  style="color:orange;font-weight: 900;"><?= str_replace('.', ',' , strval((round($person['лог']['COM_ЧЧ'],2)))); ?></td>
		                            <? else :?>
		                              <td  style="color:orange;font-weight: 900;">0</td>
		                            <? endif;?> 

		                       
		                        
		                          <? if(isset($person['лог'])) :?>
		                                <? $total = 0;?>
		                                <? foreach ($person['лог']['TYPES'] as $v => $val):?>
		                                      <? if(str_contains($v, 'Плановое') || str_contains($v, 'Журнал')) $total += $val;  ?> 
		                                <? endforeach; ?>
		                                <td  style="color:orange"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                                <td  style="color:orange">0</td>   
		                            <? endif; ?>      


		                            <? if(isset($person['лог'])) :?>
		                                <? $total = 0;?>
		                                <? foreach ($person['лог']['TYPES'] as $v => $val):?>
		                                    <?  if(str_contains($v, 'Инцидент')) $total += $val;?>
		                                <? endforeach; ?>
		                                <td  style="color:orange"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                               <td  style="color:orange">0</td>      
		                            <? endif; ?>
		                            

		                            <? if(isset($person['лог'])) :?>
		                               <? $total = 0;?>
		                               <? foreach ($person['лог']['TYPES'] as $v => $val):?>
		                                   <?  if(str_contains($v, 'Запрос'))  $total += $val; ?>
		                               <? endforeach; ?> 

		                                <td  style="color:orange"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                               <td  style="color:orange">0</td>  
		                            <? endif; ?>    

		                         <!-- /////// лог --->

		          	            

		          	            <!-- адм --->
		                          <? if(isset($person['адм'])) :?>
		                            <td  style="color:blue;font-weight: 900;"><?= str_replace('.', ',' , strval((round($person['адм']['COM_ЧЧ'],2)))); ?></td>
		                            <? else :?>
		                              <td  style="color:blue;font-weight: 900;">0</td>
		                            <? endif;?> 

		                       
		                        
		                          <? if(isset($person['адм'])) :?>
		                                <? $total = 0;?>
		                                <? foreach ($person['адм']['TYPES'] as $x => $val):?>
		                                      <? if(str_contains($x, 'Плановое') || str_contains($x, 'Журнал')) $total += $val;  ?> 
		                                <? endforeach; ?>
		                                <td  style="color:blue"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                                <td  style="color:blue">0</td>   
		                            <? endif; ?>      


		                            <? if(isset($person['адм'])) :?>
		                                <? $total = 0;?>
		                                <? foreach ($person['адм']['TYPES'] as $x => $val):?>
		                                    <?  if(str_contains($x, 'Инцидент')) $total += $val;?>
		                                <? endforeach; ?>
		                                <td  style="color:blue"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                               <td  style="color:blue">0</td>      
		                            <? endif; ?>
		                            

		                            <? if(isset($person['адм'])) :?>
		                               <? $total = 0;?>
		                               <? foreach ($person['адм']['TYPES'] as $x => $val):?>
		                                   <?  if(str_contains($x, 'Запрос'))  $total += $val; ?>
		                               <? endforeach; ?> 

		                                <td  style="color:blue"><?= str_replace('.', ',' , strval((round($total,2)))); ?> </td>
		                            <? else: ?>
		                               <td  style="color:blue">0</td>  
		                            <? endif; ?>    

		                         <!-- /////// адм --->
		          	           
		          	      	  	

		      	    	       </tr>
		      	    	    <? endif;  ?>
		      	        <? endforeach; ?>

		      	    <? endforeach; ?>

		      	<? endforeach;?>     
      	</table>    

<? endif;?>


</div>