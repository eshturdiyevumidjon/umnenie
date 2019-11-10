<?php
 
namespace app\api\modules\v1\controllers;
use Yii;
use yii\filters\auth\HttpBasicAuth; 
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery; 
use app\models\User;
use app\models\Users;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\models\PreferenceBooks;
use yii\web\UploadedFile; 
use app\models\Verification;

class AccountController extends \yii\rest\ActiveController
{            
    public $modelClass = 'app\models\Users';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            ],
        ];
                
        /*$behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
                
                $user = User::findOne(['username' => $username]);
                if($user == null) return null;
                return $user->validatePassword($password) ? $user : null;
            }
        ];*/
        //$behaviors['authenticator']['except'] = ['options'];  
        $behaviors['authenticator']['except'] = [
            'options',
            'login',
            'registry',
        ];              
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
            unset($actions['create']);
            unset($actions['update']);
            unset($actions['delete']);
            unset($actions['view']);
            unset($actions['index']);
        return $actions;
    }

    public function actionLogin()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['username'])) return ['error' => 1005];
        if(!isset($body['password'])) return ['error' => 1006];

        $user = User::find()->where(['username' => $body['username']])->one();
        if($user == null) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(404);
            return null;
        }
        if($user->validatePassword($body['password'])){
            $user->access_token = Yii::$app->getSecurity()->generateRandomString();
            $user->expire_at = time() + $user::EXPIRE_TIME;
            $user->save();
            return $user->getUsersMinValues();
        }
        else {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(404);
            return null;
        }
    }

    /**
     * +
     * регистрация
     * type => Тип пользователя (yur = Юридическое лицо, fiz = Физическое лицо) (string)
     * org_name => Название организации (string)
     * email => Email (string)
     * username => Логин/Имя пользователя (string)
     * password => Пароль (string)
     * retry_password => Повторите пароль (string)
     * fio => Ф.И.О (string)
     * phone => Номер телефона (string)
     */
    public function actionRegistry()
    {
        $model = new Users();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate() /*&& $model->save()*/ ) {


            if($model->type == 1){
                $ver = new Verification();
                $ver->sms_code = "" . rand(1,1000000);
                $ver->phone = $model->phone;  
                $ver->status = 1;
                $ver->save();

                $login = 'umnenie';
                $password = 'Umnenie09';
                $clientPhone = $model->phone;  
                $message = $ver->sms_code;

                $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';                
                $ch = curl_init();  
                curl_setopt($ch,CURLOPT_URL,$url_get);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                $result = curl_exec($ch);
                $r = json_decode($result,TRUE);
                curl_close($ch);
            }
            else{
                $ver = new Verification();
                $ver->sms_code = "" . rand(1,1000000);
                $ver->phone = $model->email;  
                $ver->status = 1;
                $ver->save();
                
                /*Yii::$app
                    ->mailer
                    ->compose()
                    ->setFrom(['itake1110@gmail.com' => 'Umnenie'])
                    ->setTo($model->email)
                    ->setSubject('Код')
                    ->setHtmlBody($ver->sms_code)
                    ->send();*/
            }

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(203);
            $responseData = ['status' => true];
            return $responseData;


        } else {
            // Validation error
            throw new HttpException(422, json_encode($model->errors));
        }
    }

    public function actionSaveRegistry()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['sms_code'])) {
            $model = new Users();
            $model->load(Yii::$app->getRequest()->getBodyParams(), '');

            $ver = Verification::find()->where(['sms_code' => $body['sms_code'], 'status' => 1])->one();
            if($ver == null) {
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(404);
                $responseData = ['error' => 1004];
                return $responseData;
            }

            if ($model->validate() && $model->save() ) {
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(201);
                $model->access_token = Yii::$app->getSecurity()->generateRandomString();
                $model->expire_at = time() + $model::EXPIRE_TIME;
                $model->save();
                $ver->status = 2;
                $ver->save();
                return $model->getUsersMinValues();
            }
            else {
                // Validation error
                throw new HttpException(422, json_encode($model->errors));
            }

        }
        else return ['error' => 'Siz telefoningizga kelgan kodni yubormadingiz'];
    }

    //user haqida barcha malumotlarni olish
    public function actionUserData()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['user_id'])) return ['error' => 1004];
        $user = Users::findOne($body['user_id']);
        if($user == null) return ['error' => 1004];
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(200);
        return $user->getUsersAllValues();
    }

        /**
     * +
     * востоновить пароля - 1
     * email => Email (string)
     */
    public function actionRestorePassword()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['phone'])) {
            $user = Users::find()->where(['phone' => $body['phone']])->one();
            if($user == null) {
                $user = Users::find()->where(['email' => $body['phone']])->one();
                if($user == null) {
                    $response = \Yii::$app->getResponse();
                    $response->setStatusCode(404);
                    $responseData = ['error' => 1004];
                    return $responseData;
                }
            }

            $user->sms_code = "" . rand(1,1000000);
            $user->save(false);

            $login = 'umnenie';
            $password = 'Umnenie09';
            $clientPhone = $body['phone'];  
            $message = $user->sms_code;

            $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';                
            $ch = curl_init();  
            curl_setopt($ch,CURLOPT_URL,$url_get);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($ch);
            $r = json_decode($result,TRUE);
            curl_close($ch);

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $responseData = ['status' => true];
            return $responseData;
        }
        else return ['error' => 1009];
    }

    public function actionCheckCode()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['sms_code'])) {
            $user = Users::find()->where(['sms_code' => $body['sms_code']])->one();
            if($user == null) {
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(404);
                $responseData = ['error' => 1004];
                return $responseData;
            }

            $user->access_token = Yii::$app->getSecurity()->generateRandomString();
            $user->expire_at = time() + $user::EXPIRE_TIME;
            $user->save();

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $responseData = ['status' => true, 'access_token' => $user->access_token];
            return $responseData;
        }
        else return ['error' => 'Siz telefoningizga kelgan kodni yubormadingiz'];
    }

    /**
     * +
     * востоновить пароля - 2
     * token => Токен для изменение паролья (string)
     * password => Пароль (string)
     * retry_password => Подтвердите новый пароль (string)
     */
    public function actionChangePassword()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $user = Users::findOne(['access_token' => $body['access_token']]);

        if($user == null) return ['error' => 1004];
        if(!isset($body['password'])) return ['error' => 1006];
        if(!isset($body['retry_password'])) return ['error' => 1010];
        if($body['password'] != $body['retry_password']) return ['error' => 1011];
        $user->new_password = (string)$body['password'];
        if(!$user->save()) return ['error' => $user->errors];
        else {
            $user->access_token = Yii::$app->getSecurity()->generateRandomString();
            $user->expire_at = time() + $user::EXPIRE_TIME;
            $user->sms_code = "";
            $user->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $responseData = $user->getUsersAllValues();
            return $responseData;
        }
    } 

    public function actionGoogle()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $accessToken = $body['accessToken'];
        $result = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$accessToken));

        $user = Users::find()->where(['google_user_id' => $result->id])->one();
        if($user == null){
            $user = new Users();
            $user->type = 1;
            $user->username = $result->given_name;
            $user->password = $result->given_name;
            $user->retry_password = $result->given_name;
            $user->fio = $result->name;
            $user->email = $result->email;

            $path_img_name  = 'profile_' . time() . '.jpg';
            $user->foto = $path_img_name;
            file_put_contents(Yii::getAlias('@app') . "/web/uploads/user/foto/" . $path_img_name, fopen($result->picture, 'r'));

            $user->google_user_id = $result->id;
        }
        $user->access_token = Yii::$app->getSecurity()->generateRandomString();
        $user->expire_at = time() + $user::EXPIRE_TIME;
        $user->save();

        return $user->getUsersMinValues();
    }

    public function actionFacebook()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $accessToken = $body['accessToken'];

        $ku = curl_init();
        $query = "access_token=".$accessToken."&fields=name,email,picture";
        
        curl_setopt($ku,CURLOPT_URL,"https://graph.Facebook.com/me"."?".$query);
        curl_setopt($ku,CURLOPT_RETURNTRANSFER,TRUE);
         
        $result = curl_exec($ku);
        if(!$result) {
            exit(curl_error($ku));
        }
         
        $result = json_decode($result);
        /*return $result;
        return json_decode($result);*/
        
        $user = Users::find()->where(['facebook_user_id' => $result->id])->one();
        if($user == null){
            $user = Users::find()->where(['email' => $result->email])->one();
            if($user == null) {
                $user = Users::find()->where(['username' => $result->name])->one();
                if($user == null) $user = new Users();
            }
            //$user = new Users();
            $user->type = 1;
            $user->email = $result->email;
            $user->fio = $result->name;
            $user->username = $result->name;
            $user->password = $result->name;
            $user->retry_password = $result->name;

            $path_img_name  = 'profile_' . time() . '.jpg';
            $user->foto = $path_img_name;
            file_put_contents(Yii::getAlias('@app') . "/web/uploads/user/foto/" . $path_img_name, fopen($result->picture->data->url, 'r'));

            $user->facebook_user_id = $result->id;
        }

        $user->access_token = Yii::$app->getSecurity()->generateRandomString();
        $user->expire_at = time() + $user::EXPIRE_TIME;
        $user->save();
        return $user->getUsersMinValues();
    }

    public function actionVkLogin()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        //return $body;
        $result = $body['user'];

        $user = Users::find()->where(['vk_user_id' => $result['id']])->one();
        if($user == null){
            $user = new Users();
            $user->type = 1;
            //$user->email = $result->email;
            $user->fio = $result['first_name'] . ' ' . $result['last_name'];
            $user->username = $result['first_name'] . ' ' . $result['last_name'];
            $user->password = $result['first_name'] . ' ' . $result['last_name'];
            $user->retry_password = $result['first_name'] . ' ' . $result['last_name'];

            /*$path_img_name  = 'profile_' . time() . '.jpg';
            $user->foto = $path_img_name;
            file_put_contents(Yii::getAlias('@app') . "/web/uploads/user/foto/" . $path_img_name, fopen($result->picture->data->url, 'r'));*/

            $user->vk_user_id = $result['id'];
            //return $user->errors;
        }
        $user->access_token = Yii::$app->getSecurity()->generateRandomString();
        $user->expire_at = time() + $user::EXPIRE_TIME;
        $user->save();
        return $user->getUsersMinValues();


//        $secret_key = $body['secret_key'];
        $mid = $body['mid'];
        return file_get_contents("https://api.vk.com/method/users.get?access_token=".md5("mriDHRK8z5J8bIz5hv93", $mid));

     	//return mb_convert_encoding(md5("mriDHRK8z5J8bIz5hv93", $mid), 'UTF-8', 'UTF-8') ;
    }

    public function actionSendSms()
    {   
        $login = 'umnenie1';
        $password = 'Umnenie091';
        $clientPhone = '';
        $text = "bu yerga text kiritilishi kerak. {name}";    
        $message = str_replace ("{name}", "FIO Klient", $text);

        $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';                
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url_get);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        $r = json_decode($result,TRUE);
        $result_tekst = $result_tekst.'  '. $r. '\n';
        curl_close($ch);
        return $result;
    }

}