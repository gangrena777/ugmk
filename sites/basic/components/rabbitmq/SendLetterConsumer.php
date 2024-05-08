<?php



namespace app\components\rabbitmq;

use Yii;
use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

use app\models\Country;

////
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
////
/*
ini_set('SMTP', "smtp.yandex.ru");
ini_set('smtp_port', "465");
ini_set('sendmail_from', "golopolosovartem@yandex.ru");
ini_set('username', "golopolosovartem");
ini_set('password', "128900mgmggmgm");
ini_set('smtpsecure', 'ssl'); 
*/
class SendLetterConsumer implements ConsumerInterface
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

     
        

                        // Yii::$app->mailer->compose(['html'=>'@app/mail/view/admin_letter'])
                        //         ->setFrom(['golopolosovartem@yandex.ru'=>'supernew_shop.ru'])
                        //         ->setTo('golopolosovartem@yandex.ru')
                        //         ->setSubject('ВАШ заказ')
                        //         ->send();



                   // $mail = new PHPMailer;
                   // $mail->CharSet = 'UTF-8';
                     
                    // Настройки SMTP
                   // $mail->isSMTP();
                   /// $mail->SMTPAuth = true;
                   // $mail->SMTPDebug = 0;
                     
                   // $mail->Host = 'ssl://smtp.yandex.ru';
                   // $mail->Port = 465;
                   // $mail->Username = 'golopolosovartem@yandex.ru';
                   // $mail->Password = '128900mgmggmgm';
                     
                    // От кого
                 //  $mail->setFrom('mail@snipp.ru', 'Snipp.ru');        
                     
                    // Кому
                  //  $mail->addAddress('golopolosovartem@yandex.ru', 'Иван Петров');
                     
                    // Тема письма
                   // $mail->Subject = $msggg['name'];
                     
                    // Тело письма
                   // $body = '<p><strong>«Hello, world!» </strong></p>';
                   // $mail->msgHTML($body);
                     
                    // Приложение
                    //$mail->addAttachment(__DIR__ . '/image.jpg');
                     
                //    if($mail->send());


             var_dump($msggg);

              
        return ConsumerInterface::MSG_ACK;

        //ConsumerInterface::MSG_ACK - Подтвердить сообщение (пометить как обработанное) и удалить его из очереди
        //ConsumerInterface::MSG_REJECT - Отклонить и удалить сообщение из очереди
        //ConsumerInterface::MSG_REJECT_REQUEUE — Отклонить и повторно поставить сообщение в очередь в RabbitMQ
    }
}