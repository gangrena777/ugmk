<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'План по заявкам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

        <p>
           Загружваем заявки в INTRASERVICE  из заранее заготовленного в определенном формате файла ( или папки).
        </p>

        

      
      <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'id' => 'upload-form'],
            'action' => ['site/upload']
        ]); ?>

        <?= Html::label('Выбирите папку или файлы для загрузки:', 'files') ?>
        <?= Html::fileInput('files[]', null, ['multiple' => true, 'id' => 'files', 'webkitdirectory' => true, 'directory' => true]) ?>
        
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
                document.getElementById('upload-form').action = `planetask`;
            });
        </script>

 <?// echo "<pre>"; print_r($regs); echo "</pre>"; ?>

<? if(isset($regs) && !empty($regs)) :?>

  <table class="table" >
     <tr>
        <th scope="col">Участок</th>
        <th scope="col">Планируемое кол-во заявок</th>
        <th scope="col">Планируемая норма на времени(часы)</th>
     </tr>

  <?foreach ($regs as $key => $value) :?>
      <tr>
        <td><?= $key;?></td>
        <td><?=$value['COUNT']; ?></td>
        <td><?= $value['SUMM']; ?></td>
        
      </tr>

  <? endforeach;?>
  </table>
<? endif; ?>


<? if(isset($array) && !empty($array)) :?>
    <div  class="done_tasks"  style="color: green">
          <div>
             <input  type="button" class="exel_download   link-success"  onclick="exportToExcel('plane_table')"  value="Скачать....в EXEL">
          </div>
          <div  id="table-conatainer">  
                  <table  class="table" id ="plane_table">
                                    <tr>
                                       <th  scope="col">№</th>
                                      <th  scope="col">Наименование заявки</th>
                                      <th  scope="col">Описание заявки</th>
                                      <th  scope="col">Планируемые трудозатраты</th>
                                      <th  scope="col">ID сервиса</th>
                                      <th  scope="col">Категории</th>
                                      <th  scope="col">Группа исполнителей</th>
                                      <th  scope="col">Приоритет</th>
                                      <th  scope="col">Заявитель</th>
                                      <th  scope="col">Тип заявки</th>
                                      <th  scope="col">Назнание участка</th>
                                      
                                    
                                    </tr> 

                                      <? foreach($array as $key =>$value)  :?>
                                          <tr  scope="row">
                                              <td  scope="col"><?= $key + 1 ?></td>
                                              <td><?= $value['Name']; ?></td>
                                              <td><?=substr($value['Description'],0 , 100); ?></td>
                                                <? $tt = (isset($value['Field1307'])) ? (floatval($value['Field1307'])) : (floatval($value['Field1302'])) ?>
                                              <td><?= str_replace('.', ',' , strval($tt)); ?></td>
                                              <td><?= $value['ServiceId']; ?></td>
                                              <td><?= $value['CategoryIds']; ?></td>
                                              <td><?= $value['ExecutorGroupId']; ?></td>
                                              <td><?= $value['PriorityId']; ?></td>
                                              <td><?= $value['CreatorId']; ?></td>
                                              <td><?= $value['TypeId'] == 5 ? 'Плановое ТО(ТО1)' :'Плановое квартальное ТО(ТО2)'; ?></td>
                                              <td><?= $value['RegionName']; ?></td>
                                          </tr>
                                      <?   endforeach;  ?>
                  </table>
          </div>

    </div>

<? endif;?>    

</div>
