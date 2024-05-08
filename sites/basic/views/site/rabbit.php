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

$this->title = 'Rabbit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' =>'country-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'code') ?>

                    <?= $form->field($model, 'population') ?>

                   

                 

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'country-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>

<? echo $code;?>


</div>

<div>
    <p>Pjax test</p>
      

            <?php Pjax::begin(['id' => 'countries']) ?>

                  <?php /*@var $dataProvider yii\data\ActiveDataProvider */ ?>
             

                         
            <?= Html::a(
                    'Обновить',
                    ['/site/pjax-country'],
                    ['class' => 'btn btn-lg btn-primary']
                ) ?>
   
            <?php Pjax::end() ?>
        
    <ul>
             <?php foreach ($dataProvider as $country): ?>
                    <li>
                        <?= Html::encode("{$country->code} ({$country->name})") ?>:
                        <?= $country->population ?>
                    </li> 
             <?php endforeach; ?>
    </ul>
   


  
        
</div>

