<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Journal;

/** @var yii\web\View $this */
/** @var app\models\Journal $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?
      $box_docs = '_';  
      if($journals  && !empty($journals)){
        $box_docs = ''; 
       foreach ($journals as  $journal){


                $box_docs .= '<p>'.Html::a($journal->journal_name, Url::to('@web/'.$journal->journal_path)).'</p>'; 
        }
}
      
        //
?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            //'region_id',
            [
                'attribute' => 'region_id',
                'value' =>$regions[$model->region_id]
            ],
          
            'dogovor_code',
            'task_name',
            
            [

               'attribute'=>'task_id',

               'format'=>'raw',
               'value' => function ($model) {
                     return Html::a($model->task_id, 'https://intraservice.ugmk-telecom.ru/Task/view/'. $model->task_id);
                  },

            ],
            
            'date_create',
            //'journal_id'
            // [
            //   'attribute'=>'journal_id',
            //   'format' =>'raw',
            //   'value'=> function( $model){
                  
            //         $Journals = Journal::find()->where(['journal_task_id' => $model->id])->all();
            //         if($Journals){
            //            foreach ($Journals as $value) {

            //             $arr = array();
            //              if($value){
            //                // return $value->journal_name;
            //               return   Html::a($value->journal_name, '@app/web/upload/journals/'. $value->journal_name);
            //               //return Yii::$app->response->sendFile('@web/upload/journals/'. $value->journal_name, $value->journal_name);
            //               }

            //           }
            //        }
            //   }
            // ],

            [
                'attribute'=>'journal_id',
                'value'=> $box_docs,
                'format'=>'raw'

            ],

        ],
    ]) ?>

</div>
