<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Testmodel $model */

$this->title = 'Update Testmodel: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Testmodels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testmodel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
