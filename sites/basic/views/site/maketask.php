<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Загрузка заявок в INTRASERVICE';
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
                document.getElementById('upload-form').action = `maketask`;
            });
        </script>





        <div  class="done_tasks"  style="color: green">
        <?
        if($done_tasks){
          echo "Успешно созданные заявки :";
          echo PHP_EOL;
          echo "<pre>";
          print_r($done_tasks);
          echo "</pre>";

        }
        ?>
        </div>
        <div class="fail_tasks" style="color: red">
        <?
        if($fail_tasks){
           echo "При создании заявок возникли ошибки :";
           echo PHP_EOL;
           foreach ($fail_tasks as $key => $value) {
                 echo "<pre>";
                 print_r($value['failedTasks'][0]);
                 echo "</pre>";
           }
        }

        ?>
        </div>
</div>
