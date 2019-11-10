<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
 
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    // 'layout' => 'newmain',
    'language' =>'ru-RU', 
    'name' => 'UMNENIE',
    'timeZone' => 'Asia/Tashkent', 
    'defaultRoute' =>'/site/dashboard',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
    	'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Api',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ], 
    ], 
    'components' => [
            'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV2' => 'your siteKey v2',
            'secretV2' => 'your secret key v2',
            'siteKeyV3' => '6LeluqYUAAAAAKrpKgK7JO3ZEVxn9K1v9uGCcIhs',
            'secretV3' => '6LeluqYUAAAAACTX3AHw4IfeUhcYfSHEPBwGpv83',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'er4tret54y6u7ir3r',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            //'loginUrl' => '/site/login'
        ],
        'errorHandler' => [
            // 'errorAction' => 'site/error',
            'errorAction' => 'site/avtorizatsiya',
        ],
         'mail' => [
                    'class' => 'yii\swiftmailer\Mailer',
                    'useFileTransport' => true,
                    'transport' => [
                        'class'=> 'Swift_SmtpTransport',
                        'host' => 'smtp.gmail.com',
                        'username' => 'umnenie@gmail.com',
                        'password' => 'Umnenie2019',
                        'port' => '465',
                        'encryption'    => 'ssl',
                ],
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'account',
                    //'pluralize'=> false, // set to false to remove the plural form
                    'extraPatterns'=>[
                        'GET test'=>'test',
                        'POST login'=>'login',
                    ],
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                // 'google'=>[
                //         'class'=>'yii\authclient\clients\GoogleOpenId'
                // ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                    'clientId' => '887520381605755',
                    'clientSecret' => '1820409306fd10e4cb9a87c94fb5a4b5',
                ],
            ],
          ],
        
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
