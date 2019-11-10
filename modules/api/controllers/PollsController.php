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

/**
 * Default controller for the `api` module
 */
class PollsController extends ActiveController
{
     public $modelClass = 'app\models\Polls';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'only' => ['list', 'viewpoll'],
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
       
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        $behaviors['authenticator']['except'] =['list', 'viewpoll'] ;
        
        return $behaviors;
    }

    public function getHeader()
    {
        //$siteName = Yii::$app->params['siteName'];
        /**/
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        /**/
        /*$origin = $_SERVER['HTTP_ORIGIN'];
        $allowed_domains = [
            'http://umnenie.foundrising.uz',
        ];
        
        if (in_array($origin, $allowed_domains)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }*/

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");     
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }
    }
    public function actionTest(){
        return ['sss'=>'sasasasa'];
    }
    public function actionList($page = 0)
    {
        //$this->getHeader();
        return Polls::getPollList($page);
    }

    public function actionView($id)
    {
        //$this->getHeader();        
        $poll = Polls::findOne($id);
        if($poll == null) return ['error' => "Bunday so'rovnoma tizimda mavjud emas"];
        
        return $poll->getOnePoll();
    }

}
