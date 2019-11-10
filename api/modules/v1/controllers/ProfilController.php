<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use app\models\Users;
use app\models\Polls;
use app\models\Settings;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use app\models\LikeSearch;
use app\models\PollsSearch;
use app\models\ChatSearch;
use app\models\Chat;
use app\models\SubscribeToUserSearch;
use app\models\BlockUser;
use app\models\Subscribes;
use app\models\User;
use app\models\PollItems;
use app\models\NewPasswordForm;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\models\Answers;
use app\models\Like;
use yii\web\UploadedFile; 
use app\models\Complaints;
use app\models\SubscribeToUser;
use app\models\Specialization;
use app\models\PollCategory;
use yii\helpers\ArrayHelper;
use app\models\PreferenceBooks;
use app\models\Verification;

class ProfilController extends \yii\rest\ActiveController
{ 	        
    public $modelClass = 'app\models\Users';
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
           'class'       => CompositeAuth::className(),
            'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::className(),
            ],
         ];
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
			'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
		];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = [
            'options',
            'restore-password',
            'change-password',
            'privacy',
            'send',
            'user-info'
        ];

        $behaviors[ 'access'] = [
            'class' =>  AccessControl::className(),
            //'only' => ['login', 'cabinet'],
            'rules' => [
                [
                    'allow' => true,
                    'actions'=>['user-info', 'send'],
                    'roles' => ['?'],
                ],                
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
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

    /**
     * +
     * Авторизация пользователя
     * username => Имя пользователя (string)
     * password => Пароль (string)
     */
    public function actionAuthorization()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['username'])) return ['error' => 1005];
        if(!isset($body['password'])) return ['error' => 1006];

        $user = User::find()->where(['username' => $body['username']])->one();
        if($user == null) return ['error' => 1007];

        if($user->validatePassword($body['password'])) return ['status' => 200, 'data' => $user->getUsersAllValues()];
        else return ['error' => 1008];
    }

    //log out
    public function actionLogout()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        if (!empty($user)) {
            $user->access_token = null;
            $user->save(false);
            Yii::$app->user->logout(false);
            return true;
        }
        throw new HttpException(422, "xatolik");
    }

    //user haqida barcha malumotlarni olish
    public function actionMe()
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $response = \Yii::$app->getResponse();
        $response->setStatusCode(200);
        $user->expire_at = time() + $user::EXPIRE_TIME;
        $user->save(); //betda bunaqa logika keremas
        return $user->getUsersAllValues();
    }

    //мои опросы
    public function actionMyPolls($page = 0)
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        return Polls::getPollList($page, $user->id, 'my-polls');
    }

    //избранные опросы
    public function actionMyFavorites()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['page'])) $page = $body['page'];
        else $page = 0;

        $user = Users::findOne(\Yii::$app->user->identity->id);        
        $selectedModel = new LikeSearch();
        $selected = $selectedModel->searchByCabinet($page, $user->id);
        return Polls::sendPollList($selected, $page, 'favorites');
    }

    //избранные опросы
    public function actionMyDrafts()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['page'])) $page = $body['page'];
        else $page = 0;

        $user = Users::findOne(\Yii::$app->user->identity->id);
        $draftModel = new PollsSearch();
        $draftDataprovider = $draftModel->searchDraft(Yii::$app->request->queryParams, $user->id, 2);
        return Polls::sendPollList($draftDataprovider, $page, 'drafts');
    }

    //referallar uchun
    public function actionMyReferalls()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['page'])) $page = $body['page'];
        else $page = 0;
        $user = Users::findOne(\Yii::$app->user->identity->id);

        $draftModel = new PollsSearch();
        $refDataprovider = $draftModel->searchReferal(Yii::$app->request->queryParams, $user->id);
        return Polls::sendPollList($refDataprovider, $page, 'referalls');
    }

    //заблокированные опросы
    public function actionMyBlocked()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['page'])) $page = $body['page'];
        else $page = 0;

        $user = Users::findOne(\Yii::$app->user->identity->id);
        $draftModel = new PollsSearch();
        $draftDataprovider = $draftModel->searchDraft(Yii::$app->request->queryParams, $user->id, 3);
        return Polls::sendPollList($draftDataprovider, $page, 'blocked');
    }

    /**
     * +
     * изменить личные данные в личном кабинете
     */
    public function actionEditProfile()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $model = Users::findOne(\Yii::$app->user->identity->id);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if(isset($body['userFIO'])) $model->fio = $body['userFIO'];
        if(isset($body['userName'])) $model->username = $body['userName'];
        if(isset($body['userComments'])) $model->comments = $body['userComments'];
        if(isset($body['userGender'])) $model->gender = $body['userGender'];

        if ($model->validate() && $model->save()) {
            $result1 = ''; 
            $i = 1; 
            foreach ( $body['category_id'] as $value) {
                if($i == 1) $result1 = $value;
                else $result1 .= ',' . $value;
                $i++;
            }

            $result = ''; 
            $i = 1; 
            foreach ( $body['specialization_id'] as $value) {
                if($i == 1) $result = $value;
                else $result .= ',' . $value;
                $i++;
            }

            $model->category_id = $result1;
            $model->specialization_id = $result;
            $model->save();

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $model = Users::findOne(\Yii::$app->user->identity->id);
            $responseData = ['status' => true, 'data' => $model->getUsersAllValues()];
            return $responseData;
        } else {
            // Validation error
            throw new HttpException(422, json_encode($model->errors));
        }
    } 

    /**
     * +
     * изменить пароля в личном кабинете ||Сменить пароль
     * old_password => Старый пароль (string)
     * password => Новый пароль (string)
     * retry_password => Подтвердите новый пароль (string)
     */
    public function actionEditPassword()
    {
        $model = new NewPasswordForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate() && $model->setPassword()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $user = Users::findOne(\Yii::$app->user->identity->id);
            $responseData = ['access_token' => $user->access_token];
            return $responseData;
        } else {
            // Validation error
            throw new HttpException(422, json_encode($model->errors));
        }
    }

    /**
     * +
     * Чат лист
     */
    public function actionChatList()
    {
        $chatModel = new ChatSearch();
        $chatList = $chatModel->searchByUserId(Yii::$app->request->queryParams, \Yii::$app->user->identity->id);
        return ['chatList' => $chatList,];
    }

    public function actionChatCreate()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['to'])) return ['error' => 'Необходимо отправить «ID» получателя.'];
        $user = Users::findOne(\Yii::$app->user->identity->id);

        //$chat = Chat::find()->where(['from' => $user->id, 'to' => $body['to'], 'deleted' => 1])->one();

        $chat = Chat::find()
            ->where(['from' => $user->id, 'to' => $body['to'], 'type' => 1, ])
            ->orWhere(['to' => $user->id, 'to' => $user->id, 'type' => 1, ])
            ->one();
        if($chat == null){
            $chat = new Chat();
            //$chat->load(Yii::$app->getRequest()->getBodyParams(), '');
            $chat->type = 1;
            $chat->chat_id = 'chat-' . $user->id . '-' . $body['to'];
            $chat->from = $user->id;
            $chat->to = $body['to'];
            $chat->deleted = 1;

            if($chat->save(false)){
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(201);
                $activeMessages = Chat::getActiveMessages($chat->chat_id, $user);
                $responseData = ['chat_id' => $chat->chat_id, 'activeMessages' => $activeMessages];
                return $responseData;
            }
            else{
                throw new HttpException(422, json_encode($chat->errors));
            }
        }
        else{
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $activeMessages = Chat::getActiveMessages($chat->chat_id, $user);
            $responseData = ['chat_id' => $chat->chat_id, 'activeMessages' => $activeMessages];
            return $responseData;
        }
    }

    public function actionChatSendText()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['to'])) return ['error' => 'Необходимо отправить «ID» получателя.'];
        if(!isset($body['text'])) return ['error' => 'Необходимо отправить текст.'];
        if(!isset($body['chat_id'])) return ['error' => 'Необходимо «ID» чата.'];
        $user = Users::findOne(\Yii::$app->user->identity->id);

        $chat = new Chat();
        //$chat->load(Yii::$app->getRequest()->getBodyParams(), '');
        $chat->type = 1;
        $chat->chat_id = $body['chat_id'];
        $chat->from = \Yii::$app->user->identity->id;
        $chat->to = $body['to'];
        $chat->text = $body['text'];
        $chat->deleted = 0;

        if($chat->save(false)){
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $activeMessages = Chat::getActiveMessages($chat->chat_id, $user);
            $responseData = ['activeMessages' => $activeMessages];
            return $responseData;
        }
        else{
            throw new HttpException(422, json_encode($chat->errors));
        }
    }

    public function actionChatMessages($chat_id)
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $activeMessages = Chat::getActiveMessages($chat_id, $user);

        $chat = Chat::find()->where(['chat_id' => $chat_id])->one();
        $to = null; $userName = null; $userFio = null; $userAvatar = null;  $userLink = null;
        if($chat != null){
            if($chat->from == $user->id) {
                $to = $chat->to;
                $userName = $chat->userTo->username;
                $userFio = $chat->userTo->getFIO();
                $userAvatar = $chat->userTo->getImage();
                $userLink = $chat->userTo->getUserCabinetLink();
            }
            else {
                $to = $chat->from;
                $userName = $chat->userFrom->username;
                $userFio = $chat->userFrom->getFIO();
                $userAvatar = $chat->userFrom->getImage();
                $userLink = $chat->userFrom->getUserCabinetLink();
            }
        }
        $responseData = [
            'to' => $to, 
            'userName' => $userName, 
            'userFio' => $userFio, 
            'userAvatar' => $userAvatar, 
            'userLink' => $userLink, 
            'activeMessages' => $activeMessages
        ];
        return $responseData;
    }

    public function actionChatSendFile()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['to'])) return ['error' => 'Необходимо отправить «ID» получателя.'];
        if(!isset($body['chat_id'])) return ['error' => 'Необходимо «ID» чата.'];
        $user = Users::findOne(\Yii::$app->user->identity->id);

        $chat = new Chat();
        //$chat->load(Yii::$app->getRequest()->getBodyParams(), '');
        $chat->type = 1;
        $chat->chat_id = $body['chat_id'];
        $chat->from = \Yii::$app->user->identity->id;
        $chat->to = $body['to'];
        $chat->deleted = 0;

        $chat->files = UploadedFile::getInstanceByName('chat_image');

        if (empty($chat->files)) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return "Must upload at least 1 file in upfile form-data POST";
        }

        if($chat->save(false)){
            $path = Yii::getAlias('@app');
            $chat->files->saveAs($path.'/web/uploads/chat/' . $chat->id.'.'.$chat->files->extension);
            $chat->file =  $chat->id.'.'.$chat->files->extension;
            $chat->save(false);

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $activeMessages = Chat::getActiveMessages($chat->chat_id, $user);
            $responseData = ['activeMessages' => $activeMessages];
            return $responseData;
        }
        else{
            throw new HttpException(422, json_encode($chat->errors));
        }
    }

    /**
     * +
     * Подписки пользователя
     */
    public function actionSubscriptions()
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        return $user->getSubscriptions();
    }

    /**
     * +
     * Подписчиков пользователя
     */
    public function actionSubscribers()
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        //подписчиков
        $subdataProvider = $user->getSubscribersDataprovider();
        //подписчики
        //$subdataProvider2 = $user->getSubscriptionsDataprovider();

        $subscribers = [];
        foreach ($subdataProvider->getModels() as $value) {
            $subscribers [] = [
                'avatar' => $value->user->getImage(),
                'userFIO' => $value->user->getFIO(),
                'userName' => $value->user->username,
                //'user_link' => $value->user->getUserCabinetLink(),
                'user_id' => $value->user->id,
            ];
        }
        return $subscribers;
    }

    /**
     * +
     * Заблокировать пользователя
     * user_id => ID пользователя (integer)
     */
    public function actionBlockUser()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $user = Users::findOne(\Yii::$app->user->identity->id);
        if(!isset($body['user_id'])) return ['error' => 1031];

        $user_id = $body['user_id'];
        $response = \Yii::$app->getResponse();

        $blockUser = Users::findOne($user_id);
        if($blockUser == null) return ['error' => 1004];

        $model = BlockUser::find()->where(['user_from' => $user->id, 'user_to' => $user_id])->one();
        if($model == null){
            $model = new BlockUser();
            $model->user_from = $user->id;
            $model->user_to = $user_id;

            if($model->save()){
                $response->setStatusCode(201);
                return ['status' => true];
            }
            else{
                throw new HttpException(422, json_encode($model->errors));
            }
        }
        else {
            if($model->delete()){
                $response->setStatusCode(201);
                return ['status' => false];
            }
            else{
                throw new HttpException(422, json_encode($model->errors));
            }
        }
    }

    /**
     * +
     * Подписаться на пользователя
     * user_id => ID пользователя (integer)
     */
    public function actionSubscribeToUser()
    {
        $response = \Yii::$app->getResponse();
        $body = Yii::$app->getRequest()->getBodyParams();
        $user = Users::findOne(\Yii::$app->user->identity->id);
        if(!isset($body['user_id'])) return ['error' => 1031];
        $user_id = $body['user_id'];

        $blockUser = Users::findOne($user_id);
        if($blockUser == null) return ['error' => 1004];

        $model = SubscribeToUser::find()->where(['user_id' => $user->id, 'user_to' => $user_id])->one();
        if($model == null){
            $model = new SubscribeToUser();
            $model->user_id = $user->id;
            $model->user_to = $user_id;

            if($model->save()){
                $response->setStatusCode(201);
                return $user->getSubscriptions();
            }
            else{
                throw new HttpException(422, json_encode($model->errors));
            }
        }
        else {
            if($model->delete()){
                $response->setStatusCode(202);
                return $user->getSubscriptions();
            }
            else{
                throw new HttpException(422, json_encode($model->errors));
            }
        }
    }

        /**
     * +
     * Подписаться/Отписаться на пользователя
     * user_id => ID пользователя (integer)
     */
    public function actionSubscribeInInfo()
    {
        $response = \Yii::$app->getResponse();
        $body = Yii::$app->getRequest()->getBodyParams();
        $user = Users::findOne(\Yii::$app->user->identity->id);
        if(!isset($body['user_id'])) return ['error' => 1031];
        $user_id = $body['user_id'];

        $blockUser = Users::findOne($user_id);
        if($blockUser == null) return ['error' => 1004];

        $model = SubscribeToUser::find()->where(['user_id' => $user->id, 'user_to' => $user_id])->one();
        if($model == null){
            $model = new SubscribeToUser();
            $model->user_id = $user->id;
            $model->user_to = $user_id;

            if($model->save()){
                $response->setStatusCode(201);
                return ['status' => true];
            }
            else{
                throw new HttpException(422, json_encode($model->errors));
            }
        }
        else {
            if($model->delete()){
                $response->setStatusCode(201);
                return ['status' => false];
            }
            else{
                throw new HttpException(422, json_encode($model->errors));
            }
        }
    }

    /**
     * Создать опраса
     * user_id => ID пользователя (integer)
     * status => status (integer)
     * type => Тип (integer)
     * question => Вопрос (text)
     * date_end => Дата окончание (date)
     * category_id => Категория (text)
     * visibility => Видимость (integer)
     * term => Срок опроса (integer)
     * view_comment => Просмотреть комментарий (integer)
     */
    public function actionCreatePoll()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        //$model = Users::findOne(\Yii::$app->user->identity->id);
        $model = new Polls();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->user_id = \Yii::$app->user->identity->id;
        $model->status = 2;

        /*$category_id = (Yii::$app->getRequest()->getBodyParam('category_id'));
        $model->category_id = implode(",", $category_id) ;*/
        $model->category_id = (string)Yii::$app->getRequest()->getBodyParam('category_id');

        if ($model->validate()) {
            //&& $model->save()
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $responseData = ['status' => true];
            return $responseData;
        } else {
            // Validation error
            throw new HttpException(422, json_encode($model->errors));
        }
    }

    public function actionSavePoll()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $poll = new Polls();
        $poll->load(Yii::$app->getRequest()->getBodyParams(), '');
        $poll->user_id = \Yii::$app->user->identity->id;
        $poll->findStatus();

        if(isset($_FILES['imageFile']['name'])){
            $path = Yii::getAlias('@app');
            $tmpFilePath = $_FILES['imageFile']['tmp_name'];
            $newFilePath = $path. '/web/uploads/polls/' . $_FILES['imageFile']['name'];
            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                $poll->image = $_FILES['imageFile']['name'];
            }
        }
        if($poll->referal_id == 'null') $poll->referal_id = null;

        if ($poll->validate() && $poll->save()) {

            foreach ($body['variants_image'] as $key => $item) {
                $model = new PollItems();
                $model->poll_id = $poll->id;
                $model->option = $item['text'];

                if(isset($_FILES['variants_image']['name'][$key])){
                    $path = Yii::getAlias('@app');
                    $tmpFilePath = $_FILES['variants_image']['tmp_name'][$key]['image'];
                    $newFilePath = $path. '/web/uploads/pollitem/' . $_FILES['variants_image']['name'][$key]['image'];
                    //Upload the file into the temp dir
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $model->image = $_FILES['variants_image']['name'][$key]['image'];
                    }
                }
                $model->save();
            }

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $pollItems = PollItems::find()->where(['poll_id' => $poll->id])->all();
            $responseData = ['status' => true, 'poll_id' => $poll->id];
            return $responseData;
        } else {
            // Validation error
            throw new HttpException(422, json_encode($poll->errors));
        }
    }

    public function actionDeleteItem()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['item_id'])) return ['error' => 'Необходимо отправить «ID» пункт опроса.'];

        $pollItem = PollItems::findOne($body['item_id']);
        if($pollItem == null) return ['error' => 'Нет такого пункт опроса в системе.'];
        if($pollItem->delete()) {
            //&& $model->save()
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(410);
            $responseData = ['status' => true];
            return $responseData;
        } else {
            throw new HttpException(422, json_encode($pollItem->errors));
        }
    }

    public function actionEditPollData($id)
    {
        $poll = Polls::findOne($id);
        if($poll == null) return ['error' => 1002];

        $pollItems = PollItems::find()->where(['poll_id' => $id])->all();
        $variants_image = [];

        foreach ($pollItems as $value) {
            $variants_image [] = [
                'id' => $value->id,
                'image' => null,
                'imageUrl' => $value->getImage(),
                'text' => $value->option,
            ];
        }

        $result = [
            'id' => $poll->id,
            'type' => $poll->type,
            'category_id' => /*explode(',', $poll->category_id),//*/$poll->category_id,
            'visibility' => $poll->visibility,
            'term' => $poll->term,
            'imagemain' => $poll->getImage(),
            'status' => $poll->status,
            'view_comment' => $poll->view_comment,
            'hashtags' => $poll->hashtags,
            'publications' => $poll->publications,
            'question' => $poll->question,
            'image' => $poll->getImage(),
            'share_count' => $poll->share_count,
            'qr_count' => $poll->qr_count,
            'variants_image' => $variants_image,
        ];

        return $result;
    }

    public function actionSavePollData($id)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        $poll = Polls::findOne($id);
        $old_status = $poll->status;
        $poll->load(Yii::$app->getRequest()->getBodyParams(), '');
        if($poll->referal_id == 'null') $poll->referal_id = null;
        $poll->changeStatus($old_status);

        if(isset($_FILES['imageFile']['name'])){
            $path = Yii::getAlias('@app');
            $tmpFilePath = $_FILES['imageFile']['tmp_name'];
            $newFilePath = $path. '/web/uploads/polls/' . $_FILES['imageFile']['name'];
            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                $poll->image = $_FILES['imageFile']['name'];
            }
        }

        if ($poll->validate() && $poll->save()) {

            $pollItems = PollItems::find()->where(['poll_id' => $id])->all();
            foreach ($pollItems as $pollItem) {
                $status = false;
                foreach ($body['variants_image'] as $key => $item) {
                    if($item['id'] == $pollItem->id) $status = true;                    
                }
                if($status == false) $pollItem->delete();
            }

            foreach ($body['variants_image'] as $key => $item) {
                $model = new PollItems();
                if($item['id'] != null) {
                    $model = PollItems::findOne($item['id']);
                    if($model == null) $model = new PollItems();
                }
                $model->option = $item['text'];
                $model->poll_id = $poll->id;

                if(isset($_FILES['variants_image']['name'][$key])){
                    $path = Yii::getAlias('@app');
                    $tmpFilePath = $_FILES['variants_image']['tmp_name'][$key]['image'];
                    $newFilePath = $path. '/web/uploads/pollitem/' . $_FILES['variants_image']['name'][$key]['image'];
                    //Upload the file into the temp dir
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        $model->image = $_FILES['variants_image']['name'][$key]['image'];
                    }
                }
                $model->save();
            }

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $pollItems = PollItems::find()->where(['poll_id' => $poll->id])->all();
            $responseData = ['status' => true, 'poll_id' => $poll->id];
            return $responseData;
        } else {
            // Validation error
            throw new HttpException(422, json_encode($poll->errors));
        }
    }

    /*Ответить на опроса*/
    public function actionAnswerToPoll()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['poll_item_id'])) return ['error' => 'Выберите вариант ответа'];
        if(!isset($body['poll_id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];

        $poll_item_id = $body['poll_item_id'];
        $poll_id = $body['poll_id'];

        $poll = Polls::findOne($poll_id);
        if($poll == null) return ['error' => 1002];

        $answer = Answers::find()->where([
            'poll_id' => $poll_id,
            'user_id' => \Yii::$app->user->identity->id
        ])->one();

        if($answer == null){
            $answer = new Answers();
            $answer->user_id = \Yii::$app->user->identity->id;
            $answer->poll_id = $poll_id;
            $answer->poll_item_id = $poll_item_id;
        }
        else{
            $answer->poll_item_id = $poll_item_id;
        }

        if($answer->save()){
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $user = Users::findOne(\Yii::$app->user->identity->id);
            $responseData = ['isVouted' => true, 'pollAnswerCount' => $poll->pollAnswerCount(), 'pollItems' => $poll->pollItems($poll_id)];
            //return $poll->pollItems($poll_id);
            return $responseData;
        }
        else{
            throw new HttpException(422, json_encode($answer->errors));
        }
    }

    /*Поставить лайк на опрос*/
    public function actionLikeToPoll()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['poll_id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];

        $poll_id = $body['poll_id'];
        $like = Like::find()->where(['poll_id' => $poll_id, 'user_id' => \Yii::$app->user->identity->id])->one();

        if($like == null) {
            $like = new Like();
            $like->user_id = \Yii::$app->user->identity->id;
            $like->poll_id = $poll_id;

            if($like->save()){
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(202);
                $responseData = ['pollLikeCount' => Like::find()->where(['poll_id' => $poll_id])->count()];
                return $responseData;
            }
            else{
                throw new HttpException(422, json_encode($like->errors));
            }
        }
        else{
            $like->delete();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(203);
            $responseData = ['pollLikeCount' => Like::find()->where(['poll_id' => $poll_id])->count()];
            return $responseData;
        }
    }

    /*Добавить комментарий к опросу (картинка)*/
    public function actionCommentToPoll()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['poll_id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];
        //if(!isset($body['text'])) return ['error' => 'Необходимо отправить текст.'];

        $poll = Polls::findOne($body['poll_id']);
        if($poll == null) return ['error' => 'Нет такого опроса в системе.'];

        $chat = new Chat();
        $chat->type = 2;
        $chat->chat_id = '#poll-'.$poll->id;
        $chat->from = \Yii::$app->user->identity->id;
        //$chat->text = $body['text'];
        $chat->deleted = 0;
        $chat->files = UploadedFile::getInstanceByName('chat_image');

        if (empty($chat->files)) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return "Must upload at least 1 file in upfile form-data POST";
        }

        $chat->load(Yii::$app->getRequest()->getBodyParams(), '');


        if($chat->save(false)){

            $path=  Yii::getAlias('@app');
            $chat->files->saveAs($path.'/web/uploads/chat/' . $chat->id.'.'.$chat->files->extension);
            $chat->file =  $chat->id.'.'.$chat->files->extension;
            $chat->save(false);

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $responseData = ['comments' => Chat::getCommentList($poll->id),];
            return $responseData;
        }
        else{
            throw new HttpException(422, json_encode($chat->errors));
        }

    }

    /*Добавить комментарий к опросу (текст)*/
    public function actionTextCommentToPoll()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['poll_id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];
        if(!isset($body['text'])) return ['error' => 'Необходимо отправить текст.'];

        $poll = Polls::findOne($body['poll_id']);
        if($poll == null) return ['error' => 'Нет такого опроса в системе.'];

        $chat = new Chat();
        $chat->type = 2;
        $chat->chat_id = '#poll-'.$poll->id;
        $chat->from = \Yii::$app->user->identity->id;
        $chat->text = $body['text'];
        $chat->deleted = 0;

        if($chat->save(false)){
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(202);
            $responseData = ['comments' => Chat::getCommentList($poll->id),];
            return $responseData;
        }
        else{
            throw new HttpException(422, json_encode($chat->errors));
        }
    }

    /*Жалобы опроса*/
    public function actionComplaint()
    {
        $model = new Complaints();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->validate() && $model->save()) {
            $model->statusVerified();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            $responseData = ['status' => true];
            return $responseData;
        } else {
            // Validation error
            throw new HttpException(422, json_encode($model->errors));
        }
    }

    /*Userga rasm quyish*/
    public function actionAddAvatar()
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $user->other_foto = UploadedFile::getInstanceByName('user_image');

        if (empty($user->other_foto)) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return "Must upload at least 1 file in upfile form-data POST";
        }
        $user->load(Yii::$app->getRequest()->getBodyParams(), '');
        $path = Yii::getAlias('@app');

        $user->other_foto->saveAs($path.'/web/uploads/user/foto/' . $user->id.'_'. time() .'.'.$user->other_foto->extension);
        Yii::$app->db->createCommand()->update('users', 
            ['foto' => $user->id.'_'. time() .'.'.$user->other_foto->extension], 
            ['id' => $user->id ]
        )->execute();

        $response = \Yii::$app->getResponse();
        $response->setStatusCode(202);
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $responseData = ['userImage' => $user->getImage()];
        return $responseData;

    }

    /*Oblojkaga rasm quyish*/
    public function actionAddBackground()
    {
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $user->other_foto = UploadedFile::getInstanceByName('user_image');

        if (empty($user->other_foto)) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return "Must upload at least 1 file in upfile form-data POST";
        }
        $user->load(Yii::$app->getRequest()->getBodyParams(), '');
        $path = Yii::getAlias('@app');

        $user->other_foto->saveAs($path.'/web/uploads/user/logo/' . $user->id.'_'. time() .'.'.$user->other_foto->extension);
        Yii::$app->db->createCommand()->update('users', 
            ['logo' => $user->id.'_'. time() .'.'.$user->other_foto->extension], 
            ['id' => $user->id ]
        )->execute();

        $response = \Yii::$app->getResponse();
        $response->setStatusCode(202);
        $user = Users::findOne(\Yii::$app->user->identity->id);
        $responseData = ['userBackground' => $user->getBackgroundImage(),];
        return $responseData;

    }

    /**
     * +
     * личный кабинет пользователя для просмотра ГОСТА
     * user_id => ID пользователя (integer)
     * page => пагинация (integer)
     */
    public function actionUserInfo()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['username'])) return ['error' => 1031];

        $user = Users::find()->where(['username' => $body['username'] ])->one();
        if($user == null) return ['error' => 1004];

        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;

        if($nowUser == null ) return $user->getUsersProfilValues();
        else{
            $block = BlockUser::find()->where(['user_to' => $nowUser->id, 'user_from' => $user->id])->one();
            if($block != null) {
                $response = \Yii::$app->getResponse();
                $response->setStatusCode(404);
                /*$responseData = ['status' => true];
                return $responseData;*/
                return ['error' => 'Пользователь '.$user->fio .' (' . $user->username . ')' . ' заблокировал вас'];
            }
            return $user->getUsersProfilValues();
        }
    }

    /**
     * +
     * Подписки пользователя для просмотра ГОСТА
     */
    public function actionUserFollowers($username)
    {
        $user = Users::find()->where(['username' => $username])->one();
        if($user == null) return ['error' => 1004];
        return $user->getSubscriptions();
    }

    /**
     * +
     * Подписчиков пользователя для просмотра ГОСТА
     */
    public function actionUserFollowing($username)
    {
        $user = Users::find()->where(['username' => $username])->one();
        if($user == null) return ['error' => 1004];

        $subdataProvider = $user->getSubscribersDataprovider();
        $subscribers = [];
        foreach ($subdataProvider->getModels() as $value) {
            $subscribers [] = [
                'avatar' => $value->user->getImage(),
                'userFIO' => $value->user->getFIO(),
                'userName' => $value->user->username,
                'user_id' => $value->user->id,
            ];
        }
        return $subscribers;
    }

    public function actionCategories()
    {
        $result = [];
        $categories = PollCategory::find()->all();
        foreach ($categories as $value) {
            $result [] = [
                'id' => $value->id,
                'name' => $value->name,
            ];
        }
        return $result;
    }

    public function actionSpecialization()
    {
        $result = [];
        $categories = PollCategory::find()->all();
        foreach ($categories as $value) {
            $result [] = [
                'id' => $value->id,
                'name' => $value->name,
            ];
        }
        return $result;
    }

    public function actionSpecializationFilter($string)
    {
        $categories = explode(',', $string);
        $result = [];
        foreach ($categories as $category) {
            $spec = PollCategory::findOne($category);
            if($spec != null){
                $result [] = [
                    'id' => (integer)$category,
                    'name' => $spec->name,
                ];                
            }
        }
        /*$specializations = Specialization::find()->all();
        foreach ($specializations as $specialization) {
            foreach ($categories as $category) {
                if($category == $specialization->category_id){
                    $result [] = [
                        'id' => $specialization->id,
                        'name' => $specialization->name,
                    ];
                }
            }            
        }*/
        return $result;
    }


    public function actionPhoneVerify()
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(isset($body['phone'])) $phone = $body['phone'];
        else $phone = null;

        $user = Users::find()->where(['phone' => $phone])->one();
        if($user !== null){
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(404);
            $responseData = ['status' => false];
            return $responseData;
        }

        $ver = new Verification();
        $ver->sms_code = "" . rand(1,1000000);
        $ver->phone = $phone;
        $ver->status = 1;
        $ver->save();

        $login = 'umnenie';
        $password = 'Umnenie09';
        $clientPhone = $phone;
        $message = $ver->sms_code;

        $url_get = 'http://smsc.ru/sys/send.php?login='.$login.'&psw='.$password.'&phones='.$clientPhone.'&mes='.$message.'&charset=utf-8';                
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url_get);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        $r = json_decode($result,TRUE);
        curl_close($ch);

        $response = \Yii::$app->getResponse();
        $response->setStatusCode(203);
        $responseData = ['status' => true];
        return $responseData;
    }

    public function actionOtp()
    {
        $body = Yii::$app->getRequest()->getBodyParams();

        $ver = Verification::find()->where(['sms_code' => $body['sms_code'], 'phone' => $body['phone'], 'status' => 1])->one();
        if($ver == null) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(404);
            $responseData = ['error' => 1004];
            return $responseData;
        }

        $ver->status = 2;
        $ver->save();

        $user = Users::find()->where(['id' => \Yii::$app->user->identity->id])->one();
        if($user !== null){
            $user->phone = $body['phone'];
            $user->verified = 1;
            $user->save();
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(200);
            return $user->getUsersMinValues();
        }
        else{
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(404);
            $responseData = ['error' => 1004];
            return $responseData;
        }
    }

    public function actionDeletePoll($page = 0)
    {
        $body = Yii::$app->getRequest()->getBodyParams();
        if(!isset($body['poll_id'])) return ['error' => 'Необходимо отправить «ID» опроса.'];
        $poll = Polls::findOne($body['poll_id']);
        if($poll == null) return ['error' => 1002];

        $email = $poll->user->email;
        if($poll->delete()) {
            /*Yii::$app
                ->mailer
                ->compose()
                ->setFrom(['umnenie@gmail.com' => 'Umnenie'])
                ->setTo($email)
                ->setSubject('Удалено опрос')
                ->setHtmlBody('Ваш опрос удалено')
                ->send();*/

            $response = \Yii::$app->getResponse();
            $response->setStatusCode(210);
            /*$responseData = ['status' => true];
            return $responseData;*/

            $user = Users::findOne(\Yii::$app->user->identity->id);
            return Polls::getPollList($page, $user->id);
        }
    }
	
}