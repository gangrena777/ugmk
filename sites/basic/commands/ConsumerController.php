<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
   * Consumers receive information
 */
namespace  app\commands;
//namespace yii\console\controllers;



use Yii;

use yii\base\Application;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\test\FixtureTrait;
use common\tools\Pusher;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class ConsumerController extends Controller
{
    private $channel;
    private  $connection;
    public function init ()
    {


       // $amqp = yii::$app->params['amqp'];

         //Create a connection to the RabbitMQ server
       // $this->connection = new AMQPStreamConnection($amqp["host"], $amqp["port"], $amqp["user"], $amqp["password"]);

         $this->connection = new AMQPStreamConnection('localhost','5672', 'guest', 'guest');
        $this->channel = $this->connection->channel();


    }
    /**
     * Loads the specified fixture data.
     * @return bool
      * Hello World receiving information
     */
    public function actionReceive(){

        try {
            //$channel = $this->channel;
            //var_dump($this->channel);exit;
             //Settings are the same as the sender. We open a connection and a channel and then declare the queue we are going to consume. Note that this matches the queue in the queue that was sent.
             //Create a connection to the RabbitMQ server
            $connection = $this->connection;
            $channel = $this->channel;
            $channel->queue_declare('hello', false, false, false, false);
            echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

            $callback = function($msg){
                echo " [x] Received ", $msg->body, "\n";
//              $msg->delivery_info['channel']->basic_ack(
//                  $msg->delivery_info['delivery_tag']);
            };

            $channel->basic_consume('hello', '', false, true, false, false, $callback);

            while(count($channel->callbacks)) {
                $channel->wait();
            }

            $channel->close();
            $connection->close();


        } catch(\Exception $e)
        {
            echo $e->getMessage();
        }
    }



}

