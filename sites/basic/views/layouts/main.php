<?php



use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

//use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Журнал ТО2', 'url' => ['/tasks/index']],
            ['label' => 'Участки', 'url' => ['/region/index']],
             //  ['label' => 'PjaxestPage', 'url' => ['/site/pjax']],
             // ['label' => 'OBJECTS', 'url' => ['/objects/index']],
            ['label' => 'Договора', 'url' => ['/dogovor/index']],
            ['label' => 'Сервисы', 'url' => ['/service/index']],

             ['label' => 'Отчеты', 'url' => ['/site/report']],
             ['label' => 'Планируемые заявки', 'url' => ['/site/planetask']],
               ['label' => 'Анализ плановой рентабильности', 'url' => ['/site/planerenttask']],

             ['label' => 'Загрузить заявки', 'url' => ['/site/maketask']],
             ['label' => 'Заведенные заявки за период', 'url' => ['/site/taketask']],
              ['label' => 'Проверить заявки', 'url' => ['/site/checkto']],

           
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();

    
    ?>

    
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>




</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
