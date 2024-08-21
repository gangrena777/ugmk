<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Analize Rent Report';
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
      <?  var_dump($error); ?>
  </div>

<? endif; ?>



<?  if(isset($array2)) :?>

        <div>
          <h3>Выборка за период : <?= $data_str; ?></h3>
        </div>
  <? //echo  "<pre>";  print_r($array); echo "</pre>"; ?>

    <div>
     <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('Fot_table3')"  value="Скачать....в EXEL">
  </div>

 <table  class="table" id ="Fot_table3">
                  <tr>
                      <th  scope="col">№</th>
                      <th  scope="col">Участок</th>
                      <th  scope="col">Договор</th>

                      <th  scope="col">План в договоре</th>

                      <th  scope="col">План ТО</th>
                      <th  scope="col">Факт общий</th>

                   
                      <th  scope="col">Комментарий</th>
                      <th  scope="col">ЧЧ по трудозатрате</th>
                  

                  
                  </tr> 
    
      <? $i = 1; ?>
      <? foreach ($array2 as $key => $region) :?>

      	<? foreach($region as $k => $contract)  :?>

             <?  if(isset($contract['PLAN_ЧЧ']))  $plan_contr = $contract['PLAN_ЧЧ'];  else  $plan_contr = "0"; ?>
             <?  if(isset($contract['FAKT_ЧЧ']))  $fakt_contr = $contract['FAKT_ЧЧ'];  else  $fakt_contr = "0"; ?>
                     
             <?  if( isset($contract['TASKS']) ) :?>
          
      	            <? foreach ($contract['TASKS'] as $z => $value) :?>
      	    	           <tr>
      	    
          		       
          	      	  	   <td><?= $i++;?></td>
          	      	  	   <td><?= $value['Участок']."/".$value['Участок__'];?></td>
          	      	  	   <td><?= $k; ?></td>

                           <td><? if($value['Д.Plan']) echo  $value['Д.Plan']; else echo "_"; ?></td>

                          
          	      	  	   <td><?= $plan_contr;?></td>
          	      	  	   <td><?= $fakt_contr;?></td>
          	      	  	   <td><? if($value['Комментарий']) echo $value['Комментарий']; else echo "_";?></td>
                           <td><?= str_replace('.', ',',floatval($value['ЧЧ']));?></td>

          	      	   
          	      	<? endforeach; ?>  
	      	
              <? endif; ?>
      	     
                      </tr>

      	<? endforeach; ?>
      	
      <? endforeach;?>

  </table>

<? endif; ?>
<p>++++++++++++++++++++++++++++++++++++++++++++++</p>

<? if(isset($array)) :?>

	   <? echo "<pre>";  print_r($array); echo "</pre>"; ?>

<? endif;?>


</div>