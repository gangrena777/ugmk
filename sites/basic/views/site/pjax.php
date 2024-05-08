<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

use yii\widgets\Pjax;
use yii\grid\GridView;




use yii\data\ActiveDataProvider;

use yii\widgets\LinkPager; 

$this->title = 'Pjax test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>


<?php Pjax::begin( 
      [
         //'enablePushState' => false  - не переопределять url
         //  'enableReplaceState' => false,
           'timeout' => 10000
       ]

 ); ?>
    <?= Html::a(
        'Случайная строка',
        ['/site/pjax?action=string'],
        ['class' => 'btn btn-lg btn-primary']
    ) ?>


    <p>Ответ сервера: <? echo $string ?></p>
<?php Pjax::end(); ?>

<?php Pjax::begin([
    'timeout' => 10000

]); ?>
    <?= Html::a(
        'Случайный ключ',
        ['/site/pjax?action=key'],
        ['class' => 'btn btn-lg btn-success']
    ) ?>
    <p>Ответ сервера: <? echo $key; ?></p>
<?php Pjax::end(); ?>

<?php Pjax::begin(
    [
         'timeout' => 9000
    ]
); ?>
  <?= Html::a("Обновить", ['site/pjax?action=time'], ['class' => 'btn btn-lg btn-primary']) ?>
   <h1>Сейчас: <?= $time ?></h1>
<?php Pjax::end(); ?>



<?php Pjax::begin([ 
    'timeout' => 10000
]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            [
                'attribute' => 'name',
                'value' => 'name',
            ],
            [
                'attribute' => 'code',
                'filter' => '<input class="form-control" style="text-transform:  uppercase;" name="filtercode" value="'.
                $searchModel['code'] .'" type="text">',
                'value' => 'code',
            ],
                        [
                'attribute' => 'population',
                'value' => 'population',
            ],
            
        ],
    ]);
    ?>
<?php Pjax::end(); ?>




</div>

