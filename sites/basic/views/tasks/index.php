<?php

use app\models\Tasks;

use app\models\Journal;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

use yii\filters\AccessControl;



/** @var yii\web\View $this */
/** @var app\models\JournalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Журнал ТО 2. Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
  <?
  // $today = date("d-m-Y H:m:s");
  // $todaytimestamp = strtotime($today);
  // echo $todaytimestamp;
  ?>

    <h1><?= Html::encode($this->title) ?></h1>

   <?  if(Yii::$app->user->can('admin') ) : ?>

    <p>
        <?= Html::a('Create Journal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <? endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
           // 'region_id',
            [
                  'attribute'=>'region_id',
                  'label' =>'Участок',

                   'format'=>'raw',
                   'value' => function (Tasks $model) use ($regions) {
                         return  $regions[$model->region_id];
                  
                      },
            ],
           
            'dogovor_code',
            'task_name',
            'task_id',
            'date_create',
            //'journal_id',
            [
              'attribute'=>'journal_id',
              'format' =>'raw',
              'options' => ['style' => 'font-size:12px;'],
              'value'=> function(Tasks $model){
                  
                    $Journals = Journal::find()->where(['journal_task_id' => $model->id])->all();
                    if($Journals){
                      $arr = '';
                       foreach ($Journals as $value) {
                         if($value){
                            $arr.=  $value->journal_name.PHP_EOL;
                          }

                      }
                      return $arr;
                   }
              }

            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tasks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
