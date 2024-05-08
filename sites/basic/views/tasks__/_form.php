<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Journal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="journal-form">
	<?
	//  if(isset($documents) && !empty($documents)){
	//     $docs_box = '';

	//     foreach ($documents as $doc) {
	           
	//            $url_delete = Url::toRoute(['objects/deletedoc','id_doc'=>$doc->id]);
	//            $docs_box .='<div class="view_doc">';
	//            $docs_box .= '<p class="doc_link">'.Html::a($doc->doc_name, Url::to('@web/web/'.$doc->doc_path)).'</p>';
	//            $docs_box .= '<a  class ="delete_doc"  href="'.$url_delete.'"   data-id ="'.$doc->id.'">&#x2715</a></div>'; 
	//     }
	// }
	?>
    

  


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dogovor_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'task_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_id[]')->fileInput(['multiple' => true])?>

     <?
        //  if(isset($akt) && !empty($akt)){

        //          echo'<div class ="documents">
        //                <label class="control-label docs">Инсктукции и файлы обьекта :</label> ';
        //         echo'<div class="documents_box">';
        //         echo $akt_box;
        //         echo'</div>';
        //         echo'</div>';
        //        echo $form->field($model, 'documents[]')->label('Добавить еще ...')->fileInput(['multiple' => true,  'class' => 'doc_del']); 

        // }else{

        //    echo $form->field($model, 'documents[]')->fileInput(['multiple' => true]);

        // }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
