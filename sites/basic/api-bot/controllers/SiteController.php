<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Country;

use yii\data\Pagination;



use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use mikemadisonweb\rabbitmq\components\Producer;
use mikemadisonweb\rabbitmq\Configuration;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {

           

            // получаем все строки из таблицы "country" и сортируем их по "name"
            $countries = Country::find()->orderBy('name')->all();

            // получаем строку с первичным ключом "US"
            $country_one = Country::findOne('US');

          

         

        $model = new ContactForm();

      

        if ($model->load(Yii::$app->request->post())/* && $model->contact(Yii::$app->params['adminEmail'])*/) {
            Yii::$app->session->setFlash('contactFormSubmitted');


            $producer = \Yii::$app->rabbitmq->getProducer('producer-send-letter');
            $msg = json_encode(['name'=>$model->name, 'email'=>$model->email, 'subject'=>$model->subject,'body'=>$model->body]);
            $producer->publish($msg, 'exchange-name','send-letter');

              // Yii::$app->mailer->compose(['html'=>'@app/mail/view/letter'], compact('session'))
              //                   ->setFrom(['golopolosovartem@yandex.ru'=>'supernew_shop.ru'])
              //                   ->setTo($orders->email)
              //                   ->setSubject('ВАШ заказ')
              //                   ->send();

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
            'countries' => $countries,
            'country_one' => $country_one
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRabbit()
    {
    	$model = new Country();

          $model2 = new ContactForm();

          $countries = Country::find()->orderBy('name')->all();



    	if($model->load(Yii::$app->request->post()) && $model->validate() ){

            // if( $model->save() ) {
            //     return $this->refresh();
    		 	
            // }

          

            $producer = \Yii::$app->rabbitmq->getProducer('producer-name2');
            $msg = json_encode(['name'=>$model->name, 'code'=>$model->code, 'population'=>$model->population]);
            $producer->publish($msg, 'exchange-name','second_key');
           
            // exit;
             return $this->refresh();
    	}
    	return $this->render('rabbit',['model' => $model,

               'dataProvider' => $countries,
               'model2' => $model2,
              ]);
    }


    public function actionPjaxCountry()
    {
          
             // получаем все строки из таблицы "country" и сортируем их по "name"
            $countries = Country::find()->orderBy('name')->all();

           /* @var $dataProvider yii\data\ActiveDataProvider */
       
            $model2 = new ContactForm();
              $model = new Country();


        return $this->render('rabbit', [ 

             'dataProvider' => $countries,
              'model' => $model,
               'model2' => $model2,
               'countries' => $countries,

           ]);
    }
       public function actionPjax()
    {
             

             $security = new \yii\base\Security();

             $req = Yii::$app->request;
             $action = $req->get('action');
       

        if ($action == "string") {
            return $this->render('pjax', [
                'string' => $security->generateRandomString(),
              
            ]);

        }
        else  if ($action == "time") {
            return $this->render('pjax', [
                'time' => date('H:i:s')
              
            ]);

        }

    
    
        else {

        $countries = Country::find()->orderBy('name')->all();


        $searchModel = [
            'code' => mb_strtoupper(Yii::$app->request->getQueryParam('filtercode', '')),
        ];

        $filteredData = array_filter($countries, function($item) use ($searchModel) {
            if (!empty($searchModel['code'])) {
                if ($item['code'] == $searchModel['code']) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        });

        //use yii\data\ActiveDataProvider;
        $dataProvider = new \yii\data\ArrayDataProvider([
            'key' => 'id',
            'allModels' =>$filteredData,
            'sort' => [
                'attributes' => ['name'],
            ],
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);

      

            return $this->render('pjax', [

                'key' => $security->generateRandomKey(),
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel

             ]);
        }


    }
}
