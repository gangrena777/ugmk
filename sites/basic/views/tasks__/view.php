<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Journal $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Journals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="journal-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'doc_id'
        ],
    ]) ?>

</div>
