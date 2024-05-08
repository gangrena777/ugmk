<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Breadcrumbs;

/** @var yii\web\View $this */
/** @var app\models\Objects $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="objects-view">

    <h1><?= Html::encode($this->title) ?></h1>

      <?php
       
       
        // foreach ($photos as  $ph){
        //         $box_photos .= '<div  class="view_photo"><a href="'.Url::to('@web/'.$ph->path).'"  rel="lightbox" >'.Html::img('@web/'.$ph->path).'</a></div>';
        // }
          foreach ($photos as  $ph){
                $box_photos .= '<div  class="view_photo"><a href="'.Url::to('@web/web/'.$ph->path).'"  rel="lightbox" >'.Html::img('@web/web/'.$ph->path).'</a></div>';
        }
      

        //$box_docs = '<div>';  
        foreach ($documents as  $doc){
                $box_docs .= '<p>'.Html::a($doc->doc_name, Url::to('@web/web/'.$doc->doc_path)).'</p>'; 
        }
        //  foreach ($documents as  $doc){
        //         $box_docs .= '<p>'.Html::a($doc->doc_name, Url::to('@web/'.$doc->doc_path)).'</p>'; 
        // }
        //$box_docs = '</div>';

        foreach ($video as  $vid){
                // $box_video .= '<div  class="view_video"><a href="'.Url::to('@web/web/'.$vid->path).'" >'.Html::img('@web/web/'.$vid->path).'</a></div>';
            $box_video .= '<video width="400" height="300" controls="controls" poster="'.Url::to('@web/web/'.$vid->path).'">
                               
                               <source src="'.Url::to('@web/web/'.$vid->path).'" type="video/mp4">
                              
                                Тег video не поддерживается вашим браузером. 
                              <a href="'.Url::to('@web/web/'.$vid->path).'">Скачайте видео</a>.
                          </video>';
        }
      
        
        ?>

    <p>
        <?= Html::a('Update', ['objects/update?id='.$model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['objects/delete?id='.$model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'addres',
            'communications',
            //'info:ntext',
            [
               'attribute' =>'Информация об обьекте',
              
               'format' => 'raw',
               'value'=>$model->info
            ],
            'description',
            [
               'attribute' =>'photos',
               'value' =>$box_photos,
               'format' => 'raw',
               'contentOptions' => ['class' => 'photos_box']
            ],
            [
                'attribute'=>'documents',
                'value'=> $box_docs,
                'format'=>'raw'

            ],
            [
                'attribute'=>'video',
                'value' =>$box_video,
                'format'=>'raw'
            ]
        ],
    ]) ?>

</div>
