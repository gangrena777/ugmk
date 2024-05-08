<?php

namespace app\components\rabbitmq;

use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

use app\models\Country;

class MyTestConsumer implements ConsumerInterface
{
    /**
     * @param AMQPMessage $msg
     * @return bool
     */
    public function execute(AMQPMessage $msg)
    {
       // sleep(1);
        //var_dump($msg->getBody());
        
            $msggg = json_decode($msg->body, true);

            $country = new Country();
            $country->name = $msggg['name'];
             $country->code = $msggg['code'];
              $country->population = $msggg['population'];
            $country->save();

             var_dump($msggg['name']);
        return ConsumerInterface::MSG_ACK;

        //ConsumerInterface::MSG_ACK - Подтвердить сообщение (пометить как обработанное) и удалить его из очереди
        //ConsumerInterface::MSG_REJECT - Отклонить и удалить сообщение из очереди
        //ConsumerInterface::MSG_REJECT_REQUEUE — Отклонить и повторно поставить сообщение в очередь в RabbitMQ
    }
}