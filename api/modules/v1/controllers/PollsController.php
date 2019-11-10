<?php

namespace app\api\modules\v1\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Polls;
use app\models\Users;
use app\models\PollItems;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\User;
use yii\filters\ContentNegotiator;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\rest\ActiveController;
use app\models\Settings;
use app\models\BlockUser;

/**
 * Default controller for the `api` module
 */
class PollsController extends ActiveController
{
    public $modelClass = 'app\models\Polls';
    public $enableCsrfValidation = false;
    /**
     * Renders the index view for the module
     * @return string
     */
    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
            'http://localhost:3000',
            'http://creators.uz',
            'http://creators.uz:3000',
        ];
    }
 

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] =  [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                'Origin'                           => ['*'],
                'Access-Control-Request-Method'    => ['POST', 'GET','PUT','DELETE','PATCH','OPTIONS'],
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Allow-Origin'      => ['*'], 
            ],
        ];        
       
        $behaviors['authenticator']['class'] = CompositeAuth::className();
        $behaviors['authenticator']['except'] = [ 'list', 'options'] ;   
         
        return $behaviors;
    }

    /**
     * +
     * список опросов или главная страница
     * page => пагинация (integer)
     */
    public function actionList($page = 0)
    {
        return Polls::getPollList($page);
    }

    /**
     * +
     * карточка опроса
     * id => ID опроса (integer)
     */
    public function actionItem($id, $username = null)
    {
        $user_id = null;
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1]))$nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;
        if($username == null) $user_id = null;
        else{
            $user = Users::find()->where([ 'username' => $username ])->one();
            if($user != null) $user_id = $user->id;
        }
        $poll = Polls::findOne($id);
        if($poll == null) return ['error' => 1002];

        if($nowUser == null ) return $poll->getOnePoll($id, $user_id, $nowUser);
        else{
            $block = BlockUser::find()->where(['user_to' => $nowUser->id, 'user_from' => $poll->user_id])->one();
            if($block != null) {
                
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(404);
                return ['error' => 'Пользователь '.$poll->user->fio .' (' . $poll->user->username . ')' . ' заблокировал вас'];
            }
            else return $poll->getOnePoll($id, $user_id, $nowUser);
        }
    }

    public function actionItem2($id, $username = null)
    {
        $user_id = null;
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1]))$nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;
        if($username == null) $user_id = null;
        else{
            $user = Users::find()->where([ 'username' => $username ])->one();
            if($user != null) $user_id = $user->id;
        }
        $poll = Polls::findOne($id);
        if($poll == null) return ['error' => 1002];

        if($nowUser == null ) return $poll->getNext($id, null, null);
        else{
            $block = BlockUser::find()->where(['user_to' => $nowUser->id, 'user_from' => $poll->user_id])->one();
            if($block != null) {
                
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(404);
                return ['error' => 'Пользователь '.$poll->user->fio .' (' . $poll->user->username . ')' . ' заблокировал вас'];
            }
            else return $poll->getNext($id, null, null);
        }
    }

    public function actionPollItemNames($id)
    {
        $poll = Polls::findOne($id);
        if($poll == null) return ['error' => 1002];

        $items = PollItems::find()->where(['poll_id' => $id])->all();
        $result = [];
        foreach ($items as $value) {
            $result [] = [
                'item_id' => $value->id,
                'itemTitle' => $value->option,
            ];
        }
        return $result;
    }

    /**
     * +
     * статистика опроса
     * id => ID опроса (integer)
     * item => Вариант ответ опроса (integer)
     */
    public function actionStatistic($id, $item = null)
    {
        if(!isset($id)) return ['error' => 1002];

        $poll = Polls::findOne($id);
        if($poll == null) return ['error' => 1003];
        return $poll->getStatistic($item);
    }

    public function actionQrCode()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];
        $poll = Polls::findOne($body['id']);
        $poll->qr_count +=1;
        if($poll->save()){
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $responseData = ['status' => true];
            return $responseData;
        }

    }

    public function actionShareLink()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];
        $poll = Polls::findOne($body['id']);
        $poll->share_count +=1;
        if($poll->save()){
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $responseData = ['status' => true];
            return $responseData;
        }
    }

    /**
     * основной поиск. пока неработает
     * search => вопрос (string)
     */
    public function actionSearch($search = null, $page = 0)
    {
        return Polls::getSearchList($search, $page);
    }

    /**
     * +
     * страница Пользовательское соглашение
     */
    public function actionPrivacy()
    {
        $settings = Settings::find()->where(['key' => 'terms_of_use'])->one();
        if($settings == null) return ['error' => 1001];
        return ['title' => $settings->name, 'text' => $settings->value];
    }


    /**
     * +
     * личный кабинет пользователя для просмотра ГОСТА
     * user_id => ID пользователя (integer)
     * page => пагинация (integer)
     */
    public function actionUserPolls($username, $page = 0)
    {
        /*$body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['username'])) return ['error' => 1031];*/

        $user = Users::find()->where(['username' => $username ])->one();
        if($user == null) return ['error' => 1004];
        return Polls::getPollList($page, $user->id, 'user-polls');
    }

}
