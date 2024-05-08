<?php

use app\models\Journal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\JournalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Журнал ТО 2. Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Journal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


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
                   'value' => function (Journal $model) use ($regions) {
                         return  $regions[$model->region_id];
                  
                      },
            ],
           
            'dogovor_code',
            'task_name',
            'task_id',
            'date_create',
            'doc_id',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Journal $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
