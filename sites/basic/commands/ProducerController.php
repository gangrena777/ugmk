<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
   * Producer Send message
 */

//namespace yii\console\controllers;
namespace app\commands;

use Yii;
use yii\base\Application;



use yii\helpers\Inflector;



use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\test\FixtureTrait;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Manages fixture data loading and unloading.
 *
 * ```
 * #load fixtures from UsersFixture class with default namespace "tests\unit\fixtures"
 * yii fixture/load User
 *
 * #also a short version of this command (generate action is default)
 * yii fixture User
 *
 * #load all fixtures
 * yii fixture "*"
 *
 * #load all fixtures except User
 * yii fixture "*, -User"
 *
 * #load fixtures with different namespace.
 * yii fixture/load User --namespace=alias\my\custom\namespace\goes\here
 * ```
 *
 * The `unload` sub-command can be used similarly to unload fixtures.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since 2.0
 */
class ProducerController extends Controller
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
      * Hello World Send message
     */
    public function actionSend(){
        try {
             //Create a connection to the RabbitMQ server
            $connection = $this->connection;
            $channel = $this->channel;
             // Next, we create a channel, which is the bulk of the API to accomplish the task.
            $channel->queue_declare('hello', false, false, false, false);
             //Build the message body
            $msg = new AMQPMessage('Hello World!');
                        //send Message
            $channel->basic_publish($msg,'','hello');

            echo " [x] Sent 'Hello World!'\n";

            $channel->close();
            $connection->close();

        } catch(\Exception $e)
        {
            echo $e->getMessage();
        }
    }

}

