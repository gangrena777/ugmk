<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Objects;
use mihaildev\ckeditor\CKEditor;

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Objects $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="objects-form">


<?php
  
    if(isset($photos) && !empty($photos)){

        $photos_box ='';

        foreach ($photos as  $photo)
        {
         $url_delete = Url::toRoute(['objects/deletephoto','id_photo'=>$photo->id]);
         $photos_box .= '<div  class="view_photo"> '.Html::img('@web/'.$photo->path).'
         <a  class ="delete_photo"  href="'.$url_delete.'"   data-id ="'.$photo->id.'">&#x2715</a></div>
         ';
        }
    }
    if(isset($documents) && !empty($documents)){
        $docs_box = '';

        foreach ($documents as $doc) {
               
               $url_delete = Url::toRoute(['objects/deletedoc','id_doc'=>$doc->id]);
               $docs_box .='<div class="view_doc">';
               $docs_box .= '<p class="doc_link">'.Html::a($doc->doc_name, Url::to('@web/'.$doc->doc_path)).'</p>';
               $docs_box .= '<a  class ="delete_doc"  href="'.$url_delete.'"   data-id ="'.$doc->id.'">&#x2715</a></div>'; 
        }
    }


 

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'communications')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'info')->widget(CKEditor::className(),[
                    'editorOptions' => [
                        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                        'inline' => false, //по умолчанию false
                    ],
        ]);
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <? if(isset($photos) && !empty($photos))
        {

                    echo'<div class ="photos">
                          <label class="control-label fotos">Фото обьекта :</label> ';
                    echo'<div class="photos_box">';
                    echo $photos_box;
                    echo'</div>';
                    echo'</div>';
                    echo $form->field($model, 'photos[]')->label('Добавить еще ...')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'photo_del']);
              
        }else{                
             
              echo $form->field($model, 'photos[]')->fileInput(['multiple' => true]);
        }
    ?>

    <?
        if(isset($documents) && !empty($documents)){

                echo'<div class ="documents">
                      <label class="control-label docs">Инсктукции и файлы обьекта :</label> ';
                echo'<div class="documents_box">';
                echo $docs_box;
                echo'</div>';
                echo'</div>';
                echo $form->field($model, 'documents[]')->label('Добавить еще ...')->fileInput(['multiple' => true,  'class' => 'doc_del']); 

        }else{

            echo $form->field($model, 'documents[]')->fileInput(['multiple' => true]);

        }
    ?>
    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
