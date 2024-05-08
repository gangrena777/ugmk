<?php

use app\models\Objects;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ObjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Objects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Objects','objects/create', ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'addres',
            'communications',
           
           [
            'attribute'=>'info:ntext',
            'label'=>'Информация об обьекте',
            'format'=>'raw', // Возможные варианты: raw, html
            'content'=>function($data){
                return $data->info;
            },
            
        ],
            //'description',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Objects $model, $key, $index, $column) {
                    return Url::toRoute([$action."?id=". $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
