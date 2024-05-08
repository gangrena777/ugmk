<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Dogovor $model */

$this->title = 'Update Dogovor: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Dogovors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dogovor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
