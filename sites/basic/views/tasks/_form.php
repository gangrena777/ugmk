<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Tasks;
use mihaildev\ckeditor\CKEditor;

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Journal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="task-form">
	<?
	 if(isset($journals) && !empty($journals)){
	    $docs_box = '';

	    foreach ($journals as $journal) {
	           
	           $url_delete = Url::toRoute(['tasks/deletedoc','id_doc'=>$journal->id]);
	           $docs_box .='<div class="view_doc">';
	           $docs_box .= '<p class="doc_link">'.Html::a($journal->journal_name, Url::to('@web/web/'.$journal->journal_path)).'</p>';
	           $docs_box .= '<a  class ="delete_doc"  href="'.$url_delete.'"   data-id ="'.$journal->id.'">&#x2715</a></div>'; 
	    }
	}
	?>
    

  


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dogovor_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_id')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'date_create')->textInput(['type' => 'datetime-local']) ?>

    <?//= $form->field($model, 'journal[]')->fileInput(['multiple' => true])?>

     <?
         if(isset($journals) && !empty($journals)){

                 echo'<div class ="documents">
                       <label class="control-label docs">Акт ТО2 :</label> ';
                echo'<div class="documents_box">';
                echo $docs_box;
                echo'</div>';
                echo'</div>';
               echo $form->field($model, 'journal[]')->label('Добавить еще ...')->fileInput(['multiple' => true,  'class' => 'doc_del']); 

        }else{

           echo $form->field($model, 'journal[]')->fileInput(['multiple' => true]);

        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
