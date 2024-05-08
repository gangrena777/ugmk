<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Dogovor $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dogovors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dogovor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
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
            'ID',
            'CODE',
            'CONTRAGENT',
            'GUID',
            'ATTRIBUT',
            'PLAN',
            'PERIOD',
            'REGION_ID',
            'NAME_NG',
            'CODE_NG',
            'USE_TMC',
        ],
    ]) ?>

</div>
