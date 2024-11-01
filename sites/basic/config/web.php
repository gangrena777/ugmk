<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$rabbitmq = require(__DIR__ . '/rabbitmq.php');
$services = require(__DIR__ . '/services.php');

$config = [
    'id' => 'basic',
    'name' =>'УГМК-ТЕЛЕКОМ',
    'basePath' => dirname(__DIR__),
   
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@appp'   =>  dirname(dirname(__DIR__)).'/basic'

    ],

    'components' => [

        'db' => [
            'class' => 'yii\db\Connection',    
            'dsn' => 'mysql:host=mysql;dbname=yii2base',
            'username' => 'root',
            'password' => 'secret',
            'charset' => 'utf8',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'l63RbVH4rZYfXNn6JGWq88D41dc8cK00',
            'baseUrl' =>'',

            'parsers' => [
                        'application/json' => 'yii\web\JsonParser',
                        'application/xml' => 'yii\web\XmlParser',
            ]
        ],
        'cache' => [

            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [

            'errorAction' => 'site/error',
        ],
   
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
             // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'enableSwiftMailerLogging' =>false,

            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => 'smtp.yandex.ru',
            //     'username' => 'golopolosovartem@yandex.ru',
            //     'password' => '128900mgmggm',
            //     'port' => '587',
            //     'encryption' => 'tls',
            // ],
                'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.ugmk-telecom.ru',
                'username' => 'gaa1@ugmk-telecom.ru',
                'password' => 'Rvp0%pr*J2',
                'port' => '587',
                'encryption' => 'tls',
            ],

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
                 [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info',  'error', 'warning'],
                    'categories' => ['task_create'],
                    'logVars' => [],
                    'logFile' => '@runtime/logs/task_create_log/myfile.log',
                ],
            ],
        ],
        'db' => $db,
        'rabbitmq'     => $rabbitmq,


        'urlManager' => [

                   'class' => 'yii\web\UrlManager',
                   'enablePrettyUrl' => true,
                   //'enableStrictParsing' => false,
                   
                   'showScriptName' => false,
                   'rules' => [
                        
                      
                                ['class' => 'yii\rest\UrlRule', 'controller' => 'objects', 'pluralize'=>false ],
                       
                                ['class' => 'yii\rest\UrlRule', 'controller' => 'api\tasks', 'pluralize'=>false,   
                                       'extraPatterns' => [
                                        'POST' => 'create', // 'xx' refers to 'actionXx'
                                        'PUT {id}' => 'update',
                                        'PATCH {id}' => 'update',
                                        'DELETE {id}' => 'delete',
                                        'GET {id}' => 'view',
                                        'GET {count}' => 'index',
                                ],

                               
                
                              ],

                   ]

                  
        ],

         
        'authManager' => [
            'class' =>  'yii\rbac\DbManager'
        ]
    ],

    'modules' => [
       

        'admin' => [    
                'class' => 'mdm\admin\Module',
                'layout' => 'left-menu', // it can be '@path/to/your/layout'.
                'mainLayout' => '@app/views/layouts/main.php',
                'controllerMap' => [
                    'assignment' => [
                        'class' => 'mdm\admin\controllers\AssignmentController',
                        //'userClassName' => 'app\models\UserIdentity',
                        'idField' => 'id'
                    ],
                    // 'other' => [
                    //     'class' => '@app\controllers\RegionController', // add another controller
                    // ],
                ],
                'menus' => [
                    'assignment' => [
                        'label' => 'Grand Access' // change label
                    ],
                    'route' => null, // disable menu route
                ]
        ],
    ],

    

    'container'  => $services,
    'params' => $params,
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'tasks/*',
            'region/*',
            'gii/*',
            'dogovor/*',
            'api/*',
            'reports/*',
            'service/*',
             //'maketask/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
       // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
