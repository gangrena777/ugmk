<?php

namespace app\commands;

use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use mikemadisonweb\rabbitmq\components\Producer;
use mikemadisonweb\rabbitmq\Configuration;
use yii\console\Controller;

class SendMyTestController extends Controller
{
    public $message = [
        'one' =>'its first',
        'two' => 'its second',
        'three' =>3
    ];

    public function options($actionID)
    {
        return ['message'];
    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    public function actionPublish($period = 1)
    {
        /** @var Producer $producer */
        $producer = \Yii::$app->rabbitmq->getProducer('producer-name2');
        while (true) {
            $producer->publish(json_encode($this->message), 'exchange-name','second_key');
            sleep($period);
        }
    }
}
