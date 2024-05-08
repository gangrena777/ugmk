<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Dogovor $model */

$this->title = 'Create Dogovor';
$this->params['breadcrumbs'][] = ['label' => 'Dogovors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dogovor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
