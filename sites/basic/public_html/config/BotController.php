<?php

namespace app\controllers\api;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;



use yii\data\Pagination;

use app\models\Objects;

use app\models\Country;

use aki\yii2-bot-telegram\base\Command;




//const Token = '5609259129:AAH3j7hIVS0SEuxR5WY1lCW_RMHKbJQgf9A';

//const API_URL = 'https://api.telegram.org/bot';

//activete bot by hook
//https://api.telegram.org/bot5609259129:AAH3j7hIVS0SEuxR5WY1lCW_RMHKbJQgf9A/setwebhook?url=https://cr45681.tmweb.ru/api/bot/
//{"ok":true,"result":true,"description":"Webhook was set"}



class BotController extends Controller{

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



    public $enableCsrfValidation = false;

	public function actionIndex()
    {
       
      
  
 

        Command::run("/start", function($telegram){
               $result = $telegram->sendMessage([
                  'chat_id' => $telegram->input->message->chat->id,
                  "text" => "hello"
                ]);
        });
       
    }



}