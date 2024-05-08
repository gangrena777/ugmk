<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Services $model */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="services-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'SERV_ID' => $model->SERV_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'SERV_ID' => $model->SERV_ID], [
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
            'SERV_ID',
            'CODE',
            'NAME',
            'DESCRIPTION',
            'isArchiv',
            'isPublic',
            'ParentId',
            'Path',
            'GUID',
            'Attribut_dogovor',
        ],
    ]) ?>

</div>
