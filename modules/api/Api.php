<?php

namespace app\modules\api;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\User;
use yii\web\Response;
use yii\filters\ContentNegotiator;
/**
 * api module definition class
 */
class Api extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'only' => ['list', 'poll'],
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            //'except' => ['login', 'register','regenerate', 'polls',],
            'only' => ['list'],
            'authMethods' => [
                [
                    'class' => HttpBasicAuth::className(),
                    'auth' => function ($username, $password) {
                        $user = User::findOne(['username' => $username]);
                        if($user == null) return null;
                        return $user->validatePassword($password) ? $user : null;
                    }
                ],
                HttpBearerAuth::className(),
                //QueryParamAuth::className()
            ],
        ];
        return $behaviors;
    }*/

    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findOne(['username' => $username]);
        if($user == null) return null;
        return $user->validatePassword($password) ? $user : null; 
    }*/
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
         \Yii::$app->setComponents([

            'request' => [

                'class'=>\yii\web\Request::class,

                'parsers' => [

                    'application/json' => 'yii\web\JsonParser',

                ],
                 'cookieValidationKey' => 'er4tret54y6u7ir3rsadkopkfsdkfksfsd',

            ],
        ]);     
        // custom initialization code goes here
    }
}
