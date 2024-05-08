<?php

return [
    'class'             => \mikemadisonweb\rabbitmq\Configuration::class,
    //'auto_declare'      => false,
    'connections'       => [
        [
           // 'host'      => 'rabbitmq',
            'host'      => 'localhost',
            'port'      => '5672',
            'user'      => 'guest',
            'password'  => 'guest',
            'vhost'     => '/',
            'heartbeat' => 0,
        ],
    ],
    'exchanges'         => [
        [
            'name' => 'exchange-name',
            'type' => 'direct',
        ],
    ],
    'queues'            => [
        [
            'name'    => 'queue-name',
            'durable' => true,
        ],
        [
            'name'    => 'queue-name2',
            'durable' => true,
        ],
        [
            'name'    => 'queue-name3',
            'durable' => true,
        ],
        [
            'name'    => 'queue-send-letter',
            'durable' => true,
        ],
    ],
    'bindings'          => [
        [
            'queue'    => 'queue-name',
            'exchange' => 'exchange-name',
            'routing_keys' => ['first_key'],
        ],
        [
            'queue'    => 'queue-name2',
            'exchange' => 'exchange-name',
             'routing_keys' => ['second_key'],
        ],
                [
            'queue'    => 'queue-send-letter',
            'exchange' => 'exchange-name',
             'routing_keys' => ['send-letter'],
        ],
    ],
    'producers'         => [
        [
            'name' => 'producer-name',
        ],
        [
            'name' => 'producer-name2',
        ],
         [
            'name' => 'producer-send-letter',
        ],
    ],
    'consumers'         => [
        [
            'name'      => 'consumer-name',
            'callbacks' => [
                'queue-name' => 'rabbitmq.example.consumer',
            ],
        ],
           [
            'name'      => 'consumer-name2',
            'callbacks' => [
                'queue-name2' => 'rabbitmq.example.consumer2',
            ],
        ],
           [
            'name'      => 'consumer-name3',//consumer with several callbacks
            'callbacks' => [
                'queue-name2' => 'rabbitmq.example.consumer2',
                 'queue-name' => 'rabbitmq.example.consumer',
                 'queue-send-letter' => 'rabbitmq.sendletter.consumer',
            ],
        ],
    ],
    'on before_consume' => function ($event)
    {
       // echo "before_consume!\n";
    },
    'on after_consume'  => function ($event)
    {
       // echo "after_consume!\n";
    },
    'on before_publish' => function ($event)
    {
       // echo "before_publish!\n";
    },
    'on after_publish'  => function ($event)
    {
      //  echo "after_publish!\n";
    },
];
