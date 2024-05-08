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
       
       
        foreach ($photos as  $ph){
                $box_photos .= '<div  class="view_photo">'.Html::img('@web/'.$ph->path).'</div>';
        }
      

        //$box_docs = '<div>';  
        foreach ($documents as  $doc){
                $box_docs .= '<p>'.Html::a($doc->doc_name, Url::to('@web/'.$doc->doc_path)).'</p>'; 
        }
        //$box_docs = '</div>';
        
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
                'value'=> $box_docs  ,
                'format'=>'raw'

            ]
        ],
    ]) ?>

</div>
