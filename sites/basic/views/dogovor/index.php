<?php

use app\models\Dogovor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DogovorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dogovors';
$this->params['breadcrumbs'][] = $this->title;

echo date("Y:m:d");
?>
<div class="dogovor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dogovor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'CODE',
            'CONTRAGENT',
            'GUID',
            'ATTRIBUT',
            'PLAN',
            'PERIOD',
            //'REGION_ID',
            [
                  'attribute'=>'REGION_ID',
                  'label' =>'Участок',

                   'format'=>'raw',
                   'value' => function (Dogovor $model) use ($regions) {
                         return  $regions[$model->REGION_ID];
                  
                      },
            ],
            'NAME_NG',
            'CODE_NG',
            'USE_TMC',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Dogovor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>
