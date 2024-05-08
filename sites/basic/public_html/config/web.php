<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EcO3tLVZHylybd2s3okmnU17bpZgI6H0',
          'baseUrl'=> '',
          
             'parsers' => [
                        'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
                'class' => 'yii\web\UrlManager',
                   'enablePrettyUrl' => true,
                   'enableStrictParsing' => false,
                   
                   'showScriptName' => false,
            'rules' => [
              
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api\objects', 'pluralize'=>false,   
                               'extraPatterns' => [
                                'POST' => 'create', // 'xx' refers to 'actionXx'
                                'PUT {id}' => 'update',
                                'PATCH {id}' => 'update',
                                'DELETE {id}' => 'delete',
                                'GET {id}' => 'view',
                                'GET {count}' => 'index',
                              ],
                          ],
                            ['class' => 'yii\rest\UrlRule', 'controller' => 'api\bot', 'pluralize'=>false ],
                            ['class' => 'yii\rest\UrlRule', 'controller' => 'objects', 'pluralize'=>false ],
                     
            ],
        ],
      'telegram' => [
		    'class' => 'aki\yii2-bot-telegram\Telegram',
		   'botToken' => '5609259129:AAH3j7hIVS0SEuxR5WY1lCW_RMHKbJQgf9A'
	   ]
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
