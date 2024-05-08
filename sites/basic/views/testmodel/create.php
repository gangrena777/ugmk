<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Testmodel $model */

$this->title = 'Create Testmodel';
$this->params['breadcrumbs'][] = ['label' => 'Testmodels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testmodel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
