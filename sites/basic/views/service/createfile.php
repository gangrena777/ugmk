<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Services $model */

$this->title = 'Create Services';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-create">

    <h1><?= Html::encode($this->title) ?></h1>


       
      <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'id' => 'upload-form'],
            
        ]); ?>

        <?= Html::label('Выбирите папку или файлы для загрузки:', 'files') ?>
        <?= Html::fileInput('files[]', null, ['multiple' => true, 'id' => 'filess']) ?>
        
        <?= Html::submitButton('Upload and Process', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>

      <script>
            document.getElementById('filess').addEventListener('change', function(event) {
            
               const files = event.target.files;
                let folderName = '';
                if (files.length > 0) {
                    const fullPath = files[0].webkitRelativePath;
                    const pathParts = fullPath.split('/');
                    folderName = pathParts[0];
                }
                document.getElementById('upload-form').action = `createfile`;
            });
        </script>

        <div>
        	
         <? if(isset($dataz) && !empty($dataz)) :?>
         <div>Successfull load services...</div>
         <div style="color:green">
         	<? echo "<pre>"; print_r($dataz);  echo "</pre>"; ?>
         </div>
         <? endif; ?>

          <? if(isset($error) && !empty($error)) :?>
          	<div>Error load services...</div>
          	<div style="color:red">
         	<? echo "<pre>"; print_r($error);  echo "</pre>"; ?>
         	</div>
         <? endif; ?>	
        
        </div>

 

</div>
