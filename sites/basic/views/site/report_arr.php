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
                <li>всего Раб  - <?= $total_work; ?></li>
                <li>всего Адм  - <?= $total_adm; ?></li>
                <li>всего Лог  - <?= $total_log; ?></li>
                <li>всего ?  - <?= $total_no; ?></li>

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
                      <th  scope="col">Факт раб</th>
                      <th  scope="col">Факт лог</th>
                      <th  scope="col">Факт адм</th>
                      <th  scope="col">Факт ?</th>

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

                          
          	      	  	   <td><? if(isset($contract['PLAN_ЧЧ'])) echo $contract['PLAN_ЧЧ'];  else  echo "0"; ?></td>
          	      	  	   <td><? if(isset($contract['FAKT_ЧЧ'])) echo $contract['FAKT_ЧЧ'];  else  echo "0"; ?></td>
                           <td><? if(isset($contract['раб']['FAKT_ЧЧ'])) echo $contract['раб']['FAKT_ЧЧ']; else echo "0";?></td>
                           <td><? if(isset($contract['лог']['FAKT_ЧЧ'])) echo $contract['лог']['FAKT_ЧЧ']; else echo "0";?></td>
                           <td><? if(isset($contract['адм']['FAKT_ЧЧ'])) echo $contract['адм']['FAKT_ЧЧ']; else echo "0";?></td>
                           <td><? if(isset($contract['']['FAKT_ЧЧ'])) echo $contract['']['FAKT_ЧЧ']; else echo "0";?></td>
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


</div>