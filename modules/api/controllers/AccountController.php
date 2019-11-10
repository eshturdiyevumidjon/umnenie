<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Polls;
use app\models\Users;
use app\models\PollItems;
use app\modules\api\LoginForm;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\User;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use app\models\PreferenceBooks;
use yii\filters\Cors;



/**
 * Default controller for the `api` module
 */
class AccountController extends ActiveController
{
    public $modelClass = 'app\models\User';
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // $behaviors['verbs'] = [
        //         'class' => \yii\filters\VerbFilter::className(),
        //         'actions' => [
        //             'login' => ['post'],
        //         ],
        //     ]; 
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'only' => ['login', 'restore-password', 'change-password'],
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ],
              
        ];
        // $behaviors['authenticator'] = [
        //     'class' => HttpBasicAuth::className(),
        //     'auth' => function ($username, $password) {
        //         $user = User::findOne(['username' => $username]);
        //         if($user == null) return null;
        //             return $user->validatePassword($password) ? $user : null;
        //     },
        // ];

        // $behaviors['authenticator']['except'] = ['login', 'restore-password', 'change-password'];
        
        // $behaviors[ 'access'] = [
        //     'class' =>  AccessControl::className(),
        //     'only' => ['login'],
        //     'rules' => [
        //         [
        //             'allow' => true,
        //             'roles' => ['@'],
        //         ],
        //     ],
        // ];
        return $behaviors;
    }

    public function actionLogin()
    {
         
        $user = User::findOne(['username' => Yii::$app->request->post('username')]);
        if($user == null) return null;
        if(!$user->validatePassword(Yii::$app->request->post('password'))) return ['status'=>401];
        
        //$user = Users::findOne(\Yii::$app->user->identity->id);
        // $user->expire_at = time() + $user::EXPIRE_TIME;
        // $user->save();
         return ['status'=>200, 'data'=>$user];
        // //return ["status"=>2000];
    }

    public function actionRestorePassword()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['email'])) {
            $user = Users::find()->where(['email' => $body['email']])->one();
            if($user == null) return ['error' => 'Такой юсер не существует в системе. Проверив отправьте повторно'];

            $siteName = Yii::$app->params['siteName'];
            $link = $siteName . '/api/account/change-password';
            $text = "Уважаемый(ая) {$user->fio}!<br>Пожалуйста, нажмите на ссылку ниже, чтобы изменить свой пароль :{$link}<br>«Umnenie» — самый популярный сайт о работе <br>Вопросы по работе с сайтом: <br>Электропочта: alltender.uz@gmail.com <br>Это письмо было отправлено автоматической рассылкой сайта Umnenie <br>© Группа компаний Yii2 Group, 2017–2019";

            //$result = PreferenceBooks::sendMessageToEmail($body['email'], 'Восстановление пароля', $text);
            return ['link' => $link, 'token' => $user->access_token];
        }
        else return ['error' => 'Необходимо заполнить «Email».'];
    }

    public function actionChangePassword()
    {
        $usersList = Users::find()->all();
        $user = null;
        foreach ($usersList as $value) {
            if(md5(md5($value->id)) == $token) $user = $value;
        }
        if($user == null) return ['error' => 'Такой токен не существует в системе. Проверив отправьте повторно'];

        echo "<pre>";
        print_r($user);
        echo "</pre>";
        die;
        $body = Yii::$app->getRequest()->getBodyParams();
    }

}
