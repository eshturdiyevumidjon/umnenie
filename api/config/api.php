<?php

$params = require(__DIR__ . '/params.php');
 
$config = [
    'id' => 'api',
    'basePath'  => dirname(__DIR__).'/..',
    'bootstrap'  => ['log'],
    'components'  => [
    'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class'=> 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'umnenie@gmail.com',
                'password' => 'Umnenie2019',
                'port' => '587',
                'encryption'    => 'tls',
        ],
    ],
        // URL Configuration for our API
        'urlManager'  => [
            'enablePrettyUrl'  => true,
            'showScriptName'  => false,
            'rules' => [
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => 'v1/account',
                    'extraPatterns' => [
                         'OPTIONS {id}' => 'options',
                         'POST login' => 'login',
                         'OPTIONS' => 'options',
                         'GET logout' => 'logout',
                    ]
                ],
                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => 'v1/profil',
                    'extraPatterns' => [
                        //'OPTIONS {id}' => 'options',
                        'OPTIONS me' => 'me',
                        'GET me' => 'me',
                        'GET send' => 'send',
                        'GET edit-poll-data' => 'edit-poll-data',
                        'POST answer-to-poll' => 'answer-to-poll',
                        'POST like-to-poll' => 'like-to-poll',
                        'POST complaint' => 'complaint'
                    ]
                ],

                [
                    'class'  => 'yii\rest\UrlRule',
                    'controller'  => 'v1/polls',
                    'extraPatterns' => [
                        //'OPTIONS {id}' => 'options',
                        'OPTIONS me' => 'me',
                        'GET me' => 'me',
                        'GET item/<id>' => 'item',
                    ]
                ],
            ],
        ],
        'request' => [
            // Set Parser to JsonParser to accept Json in request
            'parsers' => [
                'application/json'  => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'er4tret54y6u7ir3r',
            
        ],
        'mailer' => [ 
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'itake1110@gmail.com',
                'password' => '123456itake',
                'port' => '465',
                'encryption' => 'ssl',
                'streamOptions' => [ 
                    'ssl' => [ 
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]
            ],
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'alltender.uz@gmail.com',
//                'password' => 'Farkhod0916',
//                'port' => '465',
//                'encryption' => 'ssl',
//                'streamOptions' => [
//                    'ssl' => [
//                        'allow_self_signed' => true,
//                        'verify_peer' => false,
//                        'verify_peer_name' => false,
//                    ],
//                ]
//            ],
//        ],
         'response' => [
                'format' => \yii\web\Response::FORMAT_JSON
            ],
        'cache'  => [
            'class'  => 'yii\caching\FileCache',
        ],
        // Set this enable authentication in our API
        'user' => [
            'identityClass'  => 'app\models\User',
            'enableAutoLogin'  => false, // Don't forget to set Auto login to false
        ],
        // Enable logging for API in a api Directory different than web directory
        'log' => [
            'traceLevel'  => YII_DEBUG ? 3 : 0,
            'targets'  => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels'  => ['error', 'warning'],
                    // maintain api logs in api directory
                    'logFile'  => '@api/runtime/logs/error.log'
                ],
            ],
        ],
        'db'  => require(__DIR__ . '/../../config/db.php'),
    ],'modules' => [
        'v1' => [
            'basePath' => '@app/api/modules/v1', // base path for our module class
            'class' => 'app\api\modules\v1\Api', // Path to module class
        ],
    ],
    'params'  => $params,
];
 
return $config;
?>