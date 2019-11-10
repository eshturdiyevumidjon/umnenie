<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper; 
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "polls".
 *
 * @property int $id  
 * @property int $user_id Чат
 * @property string $date_cr Дата создание
 * @property string $date_end Дата окончание
 * @property int $category_id Категория 
 * @property int $visibility Видимость 
 * @property int $term Срок опроса
 * @property int $status Статус 
 * @property int $view_comment Разрешены, Запрещены
 * @property string $hashtags Хэштеги
 * @property string $publications Публикация
 * 
 * @property Category $category
 * @property Users $user
 */
class Polls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $other_image;
    public static function tableName()
    {
        return 'polls';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'visibility', 'term','type', 'status', 'view_comment', 'share_count', 'qr_count', 'referal_id'], 'integer'],
            [['date_cr', 'date_end'], 'safe'],
            [['question', 'category_id'], 'string'],
            [['hashtags', 'publications','image'], 'string', 'max' => 255],
           /* ['category_id', 'validateCategory'],*/
            [['user_id','category_id','status'], 'required'],
            // [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['referal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['referal_id' => 'id']],
            [['other_image'], 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователи',
            'type' => 'Тип',
            'date_cr' => 'Дата создание',
            'date_end' => 'Дата окончание',
            'category_id' => 'Категория',
            'visibility' => 'Видимость',
            'term' => 'Срок опроса',
            'status' => 'Статус',
            'view_comment' => 'Просмотреть комментарий',
            'hashtags' => 'Хэштеги',
            'publications' => 'Публикация',
            'question' => 'Вопрос',
            'image' => 'Фотография опроса',
            'other_image' => 'Фотография опроса',
            'share_count' => 'Кол-во Поделится',
            'qr_count' => 'Кол-во Qr Code',
            'referal_id' => 'Реферальная',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function beforeSave($insert)
    {
        if($this->date_end != null)$this->date_end = \Yii::$app->formatter->asDate($this->date_end, 'php:Y-m-d');
        if ($this->isNewRecord)
        {
            $this->date_cr = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $answer = Answers::find()->where(['poll_id' => $this->id])->all();
        foreach ($answer as $value) {
            $value->delete();
        }

        $complaint = Complaints::find()->where(['poll_id' => $this->id])->all();
        foreach ($complaint as $value) {
            $value->delete();
        }

        $elected = Elected::find()->where(['poll_id' => $this->id])->all();
        foreach ($elected as $value) {
            $value->delete();
        }

        $like = Like::find()->where(['poll_id' => $this->id])->all();
        foreach ($like as $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaints::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElecteds()
    {
        return $this->hasMany(Elected::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferal()
    {
        return $this->hasOne(Users::className(), ['id' => 'referal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getCategoryList()
    {
        $offices = PollCategory::find()->all();
        return ArrayHelper::map($offices, 'id', 'name');
    } 
    /*public function validateCategory($attribute, $params)
    {
        $category = PollCategory::find()->where(['id'=>$this->category_id])->one();
        if (!isset($category)){
            $category = new PollCategory();            
            $category->name = $this->category_id;            
            if ($category->save()){
                $this->category_id = $category->id;
            }else{
                $this->addError($attribute,"Не создано новая категория");
                echo "<pre>".print_r($category,true)."</pre>";
            }
        }
    }*/
    public function getUsers()
    {
        return ArrayHelper::map(Users::find()->all(), 'id', 'fio');
    }
    public function getVisibility()
    {
        return ArrayHelper::map([
            ['id' => '1','visibility' => 'Виден всем',],
            ['id' => '2','visibility' => 'Виден только Специалистам данной категории',],
            ['id' => '3','visibility' => 'Виден только по ссылке',], 
        ], 'id', 'visibility');
    }
    public function getTerm()
    {
        return ArrayHelper::map([
            ['id' => '1','term' => '10 мин',],
            ['id' => '2','term' => 'Час',],
            ['id' => '3','term' => 'Неделя',], 
            ['id' => '4','term' => 'Месяц',], 
        ], 'id', 'term');
    }
    public function getStatus()
    {
        return ArrayHelper::map([
            ['id' => '1','status' => 'Опубликован',],
            ['id' => '2','status' => 'Черновик',],
            ['id' => '3','status' => 'Заблокирован',], 
        ], 'id', 'status');
    }
    public function getViewComment()
    {
        return ArrayHelper::map([
            ['id' => '1','view' => 'Разрешены',],
            ['id' => '2','view' => 'Запрещены',],
        ], 'id', 'view');
    }
    public function getType()
    {
        return ArrayHelper::map([
            ['id' => '1','type' => 'Вид с выбором фоновой картинки',],
            ['id' => '2','type' => 'Вид с текстовым описанием',],
        ], 'id', 'type');
    }

    public function getPollCategory()
    {
        return ArrayHelper::map(PollCategory::find()->all(), 'id', 'name');
    }

    public function getTypes($id)
    {
        if($id == 1) return 'Вид с выбором фоновой картинки';
        if($id == 2) return 'Вид с текстовым описанием';
    }

    public function getViewComments($id)
    {
        if($id == 1) return 'Разрешены';
        if($id == 2) return 'Запрещены';
    }

    public function getStatuses($id)
    {
        if($id == 1) return 'Опубликован';
        if($id == 2) return 'Черновик';
        if($id == 3) return 'Заблокирован';
    }

    public function getTerms($id)
    {
        if($id == 1) return '10 мин';
        if($id == 2) return 'Час';
        if($id == 3) return 'Неделя';
        if($id == 4) return 'Месяц';
    }

    public function getVisibilitys($id)
    {
        if($id == 1) return 'Виден всем';
        if($id == 2) return 'Виден только Специалистам данной категории';
        if($id == 3) return 'Виден только по ссылке';
    }

    public function findStatus()
    {
        if($this->status == 1){
            $count = Polls::find()->where(['status' => 1, 'user_id' => $this->user_id])->count();
            if($count > 2) $this->status = 1;
            else $this->status = 3;
        }
    }

    public function changeStatus($old_status)
    {
        if($old_status == 2 && $this->status == 1){
            $count = Polls::find()->where(['status' => 1, 'user_id' => $this->user_id])->count();
            if($count > 2) $this->status = 1;
            else $this->status = 3;
        }
    }

    public function getImage()
    {
        $adminSiteName = Yii::$app->params['adminSiteName'];
        if($this->type == 2) {
            if($this->image == null) $pollImage = "{$adminSiteName}/img/no_image.jpg";
            else $pollImage = "{$adminSiteName}/uploads/polls/{$this->image}";
        }
        else $pollImage = null;
        return $pollImage;
    }

    public function getColorName()
    {
        $color = array(
            "#5bd6de", "#BDB76B", "#8B008B", "#99d6ff", "#aaff80", 
            "#ff8533", "#ff1aff", "#4da6ff", "#ff661a", "#1aff8c", 
            "#ff5050", "#b3b3ff", "#8cff1a", "#ff4d94", "#4dffc3", 
            '#2b5177', '#4bde95', '#58de4b', '#d9de4b', '#de4b8c', 
            '#731d43', '#db8535', '#cd3014', '#2214cd', '#5b99de', 
            '#9be42e', '#2e4ae4', '#07176e', '#195213', '#ff3503'
        );
        $rang = rand(1, 29);
        return $color[$rang];
    }

    public function getCategorySpecialisation()
    {
        $array = explode(',', $this->category_id);
        $cat = PollCategory::find()->where(['in', 'id', $array])->all();
        $result = [];
        foreach ($cat as $value) {
            $result [] = $value->id;
        }

        /*$spec = PollCategory::find()->where(['category_id' => $this->category_id])->all();
        $result = [];
        foreach ($spec as $value) {
            $result [] = $value->id;
        }*/
        return $result;
    }

    public function getNext($user_id) 
    {
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;

        if($nowUser != null) {
            $IdList = [];
            $userCategories = $nowUser->getCategoriesList();
            $spec = $nowUser->getSpecialisationList();
            if($user_id != null) $userCategories = $nowUser->getCatIdList();

            if($user_id != null) $list = Polls::find()
                ->where(['user_id' => $user_id, 'status' => 1])
                ->andWhere(['in', 'visibility', [1,2,3]])
                ->andWhere(['in', 'category_id', $userCategories])
                ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
                ->all();
            else $list = Polls::find()
                ->where(['status' => 1])
                ->andWhere(['in', 'visibility', [1,2]])
                ->andWhere(['in', 'category_id', $userCategories])
                ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
                ->all();
                
            foreach ($list as $value) {                
                if($value->visibility == 2){
                    $pollSpec = $value->getCategorySpecialisation();
                    if($value->user_id == $nowUser->id) $IdList [] = $value->id;
                    if($spec != null){
                        foreach ($spec as $sp) {
                            if(in_array($sp, $pollSpec)) {$IdList [] = $value->id; break;}
                        }
                    }
                }
                else $IdList [] = $value->id;
            }
            $polls = Polls::find()->where(['id' => $IdList])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])->all();
        }
        else{
            if($user_id != null) $polls = Polls::find()->where(['user_id' => $user_id, 'status' => 1])->andWhere(['visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])->all();
            else $polls = Polls::find()->where(['status' => 1])->andWhere(['visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])->all();
        }

        $next = null; $status = 0;
        foreach ($polls as $poll) {
            if($this->id == $poll->id) {
                $prev = $next;
                break;
            }
            $next = $poll;
        }
        return $next;
    }

    public function getPrev($user_id) 
    {
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;
        $spec = null;

        if($nowUser != null) {
            $userCategories = $nowUser->getCategoriesList();
            $spec = $nowUser->getSpecialisationList();
            //if($type == 'my-polls') $userCategories = $nowUser->getCatIdList();
            if($user_id != null) $userCategories = $nowUser->getCatIdList();

            if($user_id != null) $list = Polls::find()
                ->where(['user_id' => $user_id, 'status' => 1])
                ->andWhere(['in', 'visibility', [1,2,3]])
                ->andWhere(['in', 'category_id', $userCategories])
                ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
                ->all();
            else $list = Polls::find()
                ->where(['status' => 1])
                ->andWhere(['in', 'visibility', [1,2]])
                ->andWhere(['in', 'category_id', $userCategories])
                ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
                ->all();
                
        }
        else{
            if($user_id != null) $list = Polls::find()->where(['user_id' => $user_id, 'status' => 1])->andWhere(['in', 'visibility', [1,2,3]])->orderBy(['date_cr' => SORT_ASC, 'id' => SORT_ASC])->all();
            else $list = Polls::find()->where(['status' => 1])->andWhere(['in', 'visibility', [1,2]])->orderBy(['date_cr' => SORT_ASC, 'id' => SORT_ASC])->all();
        }

        $IdList = [];
        foreach ($list as $value) {
            if($value->visibility == 2){
                $pollSpec = $value->getCategorySpecialisation();
                if($nowUser != null && $value->user_id == $nowUser->id) $IdList [] = $value->id;
                if($spec != null){
                    foreach ($spec as $sp) {
                        if(in_array($sp, $pollSpec)) {$IdList [] = $value->id; break;}
                    }
                }
            }
            else $IdList [] = $value->id;
        }
        $polls = Polls::find()->where(['id' => $IdList])->orderBy(['date_cr' => SORT_ASC, 'id' => SORT_ASC])->all();

        $old = null; $status = 0; $prev = null;
        foreach ($polls as $poll) {
            if($this->id === $poll->id) {
                $prev = $old;
                break;
            }
            $old = $poll;
        }
        return $prev;

        /*if($user_id != null) {
            $old = null; $status = 0; $prev = null;
            foreach ($polls as $poll) {
                if($this->id === $poll->id) {
                    $prev = $old;
                    break;
                }
                $old = $poll;
            }
        }
        else $prev = $this->find()->where(['<', 'id', $this->id])->andWhere(['visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])->one();
        return $prev;*/
    }

    public static function getNextPage($user_id, $page, $_query = null, $my = null)
    {        
        /*$controller_name = Yii::$app->controller->id;*/
        /*$siteName = Yii::$app->params['siteName'];*/
        $cont = Yii::$app->controller->id;
        $action =Yii::$app->controller->action->id;
        $url = $cont . '/' . $action;
        $next = null;
        $defaultPageSize = Yii::$app->params['defaultPageSize'];

        if($my == null) {
	        if($_query == null){
	            if($user_id != null) $query = Polls::find()->where(['user_id' => $user_id, 'status' => 1, 'visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC]);
	            else $query = Polls::find()->where(['status' => 1, 'visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC]);
	        }
	        else $query = $_query;
	    }
	    else {
	    	if($my == 'favorites'){
	    		$query = Like::find()->where(['user_id' => $user_id]);
		        $dataProvider = new ActiveDataProvider(['query' => $query,]);

		        $result = [];
		        foreach ($dataProvider->getModels() as $value) {
		           $result [] = $value->poll_id;
		        }
		        $query = Polls::find()->where(['id' => $result]);
	    	}
	    	if($my == 'drafts'){
	    		$query = Polls::find()->where(['user_id' => $user_id, 'status' => 2]);
	    	}
            if($my == 'blocked'){
                $query = Polls::find()->where(['user_id' => $user_id, 'status' => 3]);
            }
	    	if($my == 'referalls'){
	    		$query = Polls::find()->where(['referal_id' => $user_id]);
	    	}
	    }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize, //set page size here
                'page' => $page + 1,
            ]
        ]);

        if($dataProvider->getCount() > 0) {
            $next = $url . "?page=".($page + 1);
            /*if($controller_name == 'polls') $next = "polls/list?page=".($page + 1);
            if($controller_name == 'profil') $next = "profil/cabinet?page=".($page + 1);*/
        }
        return $next;
    }

    public static function getOldPage($user_id, $page, $my) 
    {
        //$controller_name = Yii::$app->controller->id;
        $cont = Yii::$app->controller->id;
        $action =Yii::$app->controller->action->id;
        $url = $cont . '/' . $action;

        $previous = null;
        $siteName = Yii::$app->params['siteName'];
        if($page > 0) {
            $previous = $url . "?page=".($page - 1);
            /*if($controller_name == 'polls') $previous = "polls/list?page=".($page - 1);
            if($controller_name == 'profil') $previous = "profil/cabinet?page=".($page - 1);*/
        }
        return $previous;
    }

    public static function getPollList($page, $user_id = null, $type = null)
    {   
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;

        if($nowUser != null) {
            $IdList = [];
            $userCategories = $nowUser->getCategoriesList();
            $spec = $nowUser->getSpecialisationList();
            if($type == 'my-polls' || $type == 'user-polls') $userCategories = $nowUser->getCatIdList();

            if($user_id != null) $list = Polls::find()
                ->where(['user_id' => $user_id, 'status' => 1])
                ->andWhere(['in', 'visibility', [1,2,3]])
                ->andWhere(['in', 'category_id', $userCategories])
                ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
                ->all();
            else $list = Polls::find()
                ->where(['status' => 1])
                ->andWhere(['in', 'visibility', [1,2]])
                ->andWhere(['in', 'category_id', $userCategories])
                ->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC])
                ->all();
                
            //return $list;
            foreach ($list as $value) {                
                if($value->visibility == 2){
                    $pollSpec = $value->getCategorySpecialisation();
                    if($value->user_id == $nowUser->id) $IdList [] = $value->id;
                    if($spec != null){
                        foreach ($spec as $sp) {
                            if(in_array($sp, $pollSpec)) {$IdList [] = $value->id; break;}
                        }
                    }
                }
                else $IdList [] = $value->id;
            }
            $query = Polls::find()->where(['id' => $IdList])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC]);
        }
        else{
            if($user_id != null) $query = Polls::find()->where(['user_id' => $user_id, 'status' => 1])->andWhere(['visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC]);
            else $query = Polls::find()->where(['status' => 1])->andWhere(['visibility' => 1])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC]);
        }

        $siteName = \Yii::$app->params['siteName'];
        $defaultPageSize = \Yii::$app->params['defaultPageSize'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize, //set page size here
                'page' => $page,
            ]
        ]);
        
        return Polls::sendPollList($dataProvider, $page, $user_id);
    }

    public function pollAnswerCount()
    {
        return Answers::find()->where(['poll_id' => $this->id])->count();
    }

    public static function pollItems($poll_id)
    {
        $items = [];
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;

        $pollItems = PollItems::find()->where(['poll_id' => $poll_id])->all();
        foreach ($pollItems as $item) {
            if($nowUser != null && Answers::find()->where(['user_id' => $nowUser->id, 'poll_item_id' => $item->id])->one() != null ) $isVoutedMe = true;
            else $isVoutedMe = false;

            $items [] = [
                'id' => $item->id,
                'option' => $item->option,
                'percent' => $item->getCount(),
                'isVoutedMe' => $isVoutedMe,
                'image' => $item->getImage(),
                'avatars' => $item->getSelectedUsersAvatar(),
            ];
        }
        return $items;
    }

    public static function sendPollList($dataProvider, $page, $user_id = null, $my = null)
    {   
        if($dataProvider->getCount() == 0) return [];

        $siteName = Yii::$app->params['siteName'];
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;

        $result = [];
        foreach ($dataProvider->getModels() as $poll) {
            $items = [];
            $pollItems = PollItems::find()->where(['poll_id' => $poll->id])->all();
            if($nowUser != null && $nowUser->id == $poll->user_id) $edit = true;
            else $edit = false;

            if($nowUser != null && Like::find()->where(['poll_id' => $poll->id, 'user_id' => $nowUser->id])->one() != null ) $like = true;
            else $like = false;

            if($nowUser != null && Answers::find()->where(['poll_id' => $poll->id, 'user_id' => $nowUser->id])->one() != null ) $isVouted = true;
            else $isVouted = false;

            if($nowUser != null /*&& $nowUser->id == $poll->user_id*/ ) $viewStatistic = true;
            else $viewStatistic = false;

            if($nowUser != null && $nowUser->id == $poll->user_id ) $isDeleted = true;
            else $isDeleted = false;

            foreach ($pollItems as $item) {
                if($nowUser != null && Answers::find()->where(['poll_id' => $poll->id, 'user_id' => $nowUser->id, 'poll_item_id' => $item->id])->one() != null ) $isVoutedMe = true;
                else $isVoutedMe = false;

                $items [] = [
                    'id' => $item->id,
                    'option' => $item->option,
                    'percent' => $item->getCount(),
                    'isVoutedMe' => $isVoutedMe,
                    'image' => $item->getImage(),
                    'avatars' => $item->getSelectedUsersAvatar(),
                ];
            }
            $result [] = [
                'userId' => $poll->user->id,
                'userFIO' => $poll->user->getFIO(),
                'userName' => $poll->user->username,
                'userImage' => $poll->user->getImage(),
                'pollId' => $poll->id,
                'edit' => $edit,
                'like' => $like,
                'isVouted' => $isVouted,
                'isDelete' => $isDeleted,
                'viewStatistic' => $viewStatistic,
                'pollUrl' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollEdit' => "{$siteName}/v1/profil/edit-poll?id={$poll->id}",
                'pollStatistic' => "{$siteName}/v1/polls/statistic?id={$poll->id}",
                'pollComment' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollQrCode' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollShare' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollСomplaint' => "{$siteName}/v1/polls/complaint?id={$poll->id}",
                'pollLikeCount' => Like::find()->where(['poll_id' => $poll->id])->count(),
                'pollType' => $poll->type,
                'pollTypeText' => $poll->getType()[$poll->type],
                'pollAnswerCount' => $poll->pollAnswerCount(),
                'pollCategory' => 'vaqtinchalik category', //$poll->getCategoryList()[$poll->category_id],
                'pollVisibility' => $poll->visibility, //$poll->getVisibility()[$poll->visibility],
                'pollTerm' => $poll->term, //$poll->getTerm()[$poll->term],
                'pollViewComment' => $poll->view_comment == 2 ? false : true,
                'pollHashtags' => $poll->hashtags,
                'pollCrown' => $poll->visibility == 2 ? true : false,
                'pollPublications' => $poll->publications,
                'pollEndDate' => $poll->date_cr != null ? date('d.m.Y', strtotime($poll->date_cr)) : null,
                'pollQuestion' => $poll->question,
                'pollImage' => $poll->getImage(),
                'disableCard' => $poll->disableCard(),
                'items' => $items,
            ];
        }

        $polls = [
            'count' => $dataProvider->getCount(),
            'next' => Polls::getNextPage($user_id,$page, $my),
            'previous' => Polls::getOldPage($user_id,$page, $my),
            'result' => $result,
        ];
        return $polls;
    }

    public static function getOnePoll($id, $user_id, $nowUser = null)
    {
        $poll = Polls::findOne($id);
        $next = $poll->getNext($user_id);
        $prev = $poll->getPrev($user_id);
        $nextUrl = null;
        $prevUrl = null;
        $items = [];
        
        if($nowUser != null && $nowUser->id == $poll->user_id) $edit = true;
        else $edit = false;

        if($nowUser != null && Like::find()->where(['poll_id' => $poll->id, 'user_id' => $nowUser->id])->one() != null ) $like = true;
        else $like = false;
        //return $nowUser;
        if($nowUser != null && Answers::find()->where(['poll_id' => $poll->id, 'user_id' => $nowUser->id])->one() != null ) $isVouted = true;
        else $isVouted = false;

        if($nowUser != null /*&& $nowUser->id == $poll->user_id*/ ) $viewStatistic = true;
        else $viewStatistic = false;

        if($nowUser != null && $nowUser->id == $poll->user_id ) $isDeleted = true;
        else $isDeleted = false;

        $siteName = Yii::$app->params['siteName'];
        if($next != null) $nextUrl = $next->id;//"{$siteName}/v1/polls/item?id={$next->id}";
        if($prev != null) $prevUrl = $prev->id;//"{$siteName}/v1/polls/item?id={$prev->id}";

        $pollItems = PollItems::find()->where(['poll_id' => $poll->id])->all();
        foreach ($pollItems as $item) {
            if($nowUser != null && Answers::find()->where(['poll_id' => $poll->id, 'user_id' => $nowUser->id, 'poll_item_id' => $item->id])->one() != null ) $isVoutedMe = true;
            else $isVoutedMe = false;
            $items [] = [
                'id' => $item->id,
                'option' => $item->option,
                'percent' => $item->getCount(),
                'isVoutedMe' => $isVoutedMe,
                'image' => $item->getImage(),
                'avatars' => $item->getSelectedUsersAvatar(),
            ];
        }
        $result = [
            'userId' => $poll->user->id,
            'userFIO' => $poll->user->getFIO(),
            'userName' => $poll->user->username,
            'userImage' => $poll->user->getImage(),
            'pollId' => $poll->id,
            'edit' => $edit,
            'like' => $like,
            'isVouted' => $isVouted,
            'isDelete' => $isDeleted,
            'viewStatistic' => $viewStatistic,
            'pollUrl' => "{$siteName}/v1/polls/item?id={$poll->id}",
            'pollEdit' => "{$siteName}/v1/profil/edit-poll?id={$poll->id}",
            'pollStatistic' => "{$siteName}/v1/polls/statistic?id={$poll->id}",
            'pollComment' => "{$siteName}/v1/polls/item?id={$poll->id}",
            'pollQrCode' => "{$siteName}/v1/polls/item?id={$poll->id}",
            'pollShare' => "{$siteName}/v1/polls/item?id={$poll->id}",
            'pollСomplaint' => "{$siteName}/v1/polls/complaint?id={$poll->id}",
            'pollLikeCount' => Like::find()->where(['poll_id' => $poll->id])->count(),
            'pollType' => $poll->type,
            'pollTypeText' => $poll->getType()[$poll->type],
            'pollAnswerCount' => $poll->pollAnswerCount(),
            'pollLikeCount' => Like::find()->where(['poll_id' => $poll->id])->count(),
            'pollCategory' => 'vaqtinchalik category', //$poll->getCategoryList()[$poll->category_id],
            'pollVisibility' => $poll->getVisibility()[$poll->visibility],
            'pollTerm' => $poll->getTerm()[$poll->term],
            'pollViewComment' => $poll->view_comment == 2 ? false : true,
            'pollHashtags' => $poll->hashtags,
            'pollCrown' => $poll->visibility == 2 ? true : false,
            'pollPublications' => $poll->publications,
            'pollEndDate' => $poll->date_cr != null ? date('d.m.Y', strtotime($poll->date_cr)) : null,
            'pollQuestion' => $poll->question,
            'pollImage' => $poll->getImage(),
            'prevPoll' => $prevUrl,
            'nextPoll' => $nextUrl,
            'items' => $items,
            'disableCard' => $poll->disableCard(),
            'comments' => Chat::getCommentList($poll->id),
        ];

        return [
            'data' => $result
        ];
    }

    public function disableCard()
    {
        if($this->term == 1) {
            //return '10 мин';
            $minut = strtotime(date("Y-m-d H:i:s", strtotime($this->date_cr)) . " +10 min");
            if(time() > $minut ) return false;
            else return true;
        }
        if($this->term == 2) {
            //return 'Час';
            $hour = strtotime(date("Y-m-d H:i:s", strtotime($this->date_cr)) . " +10 hour");
            if(time() > $hour ) return false;
            else return true;
        }
        if($this->term == 3) {
            //return 'Неделя';
            $week = strtotime(date("Y-m-d", strtotime($this->date_cr)) . " +1 week");
            if(time() > $week ) return false;
            else return true;
        }
        if($this->term == 4) {
            //return 'Месяц';
            $month = strtotime(date("Y-m-d", strtotime($this->date_cr)) . " +1 month");
            if(time() > $month ) return false;
            else return true;
        }
    }

    public function getStatistic($item)
    {
        if($item == null) $condition = ['answers.poll_id' => $this->id];
        else $condition = ['answers.poll_id' => $this->id, 'answers.poll_item_id' => $item];
        $totalAnswerCount = Answers::find()->where($condition)->count();

        $city = Answers::find()
            ->select(['users.address as cityname', 'COUNT(*) AS count'])
            ->joinWith('user', false)
            ->where($condition)
            ->groupBy('users.address')
            ->asArray()
            ->all();

        $answers = Answers::find()->where($condition)->all();

        $proffStatus = Answers::find()
            ->select(['users.profi_status as profi_status', 'COUNT(*) AS count'])
            ->joinWith('user', false)
            ->where($condition)
            ->groupBy('users.profi_status')
            ->asArray()
            ->all();

        $likeCount = Like::find()->where(['poll_id' => $this->id])->count();
        $chatCount = Chat::find()->where(['chat_id' => "#poll-". $this->id, 'type' => 2])->count();

        $youth24 = date('Y-m-d', strtotime('-24 years'));
        $youth25 = date('Y-m-d', strtotime('-25 years'));
        $youth18 = date('Y-m-d', strtotime('-18 years'));
        $youth34 = date('Y-m-d', strtotime('-34 years'));
        $youth45 = date('Y-m-d', strtotime('-45 years'));
        $youth54 = date('Y-m-d', strtotime('-54 years'));

        $firstYouth = Answers::find()
            ->joinWith('user', false)
            ->where($condition)
            ->andWhere(['between', 'users.birthday', $youth34, $youth25])
            ->count();

        $secondYouth = Answers::find()
            ->joinWith('user', false)
            ->where($condition)
            ->andWhere(['between', 'users.birthday', $youth24, $youth18])
            ->count();

        $thirdYouth = Answers::find()
            ->joinWith('user', false)
            ->where($condition)
            ->andWhere(['between', 'users.birthday', $youth54, $youth45])
            ->count();

        $fourYouth = Answers::find()
            ->joinWith('user', false)
            ->where($condition)
            ->andWhere(['<=', 'users.birthday', $youth18])
            ->andWhere(['!=', 'users.birthday', null])
            ->count();
            //return $fourYouth;

        $totalCount = $firstYouth + $secondYouth + $thirdYouth + $fourYouth;
        $firstProsent = $totalCount == 0 ? 0 : 100 * $firstYouth / $totalCount;
        $secondProsent = $totalCount == 0 ? 0 : 100 * $secondYouth / $totalCount;
        $thirdProsent = $totalCount == 0 ? 0 : 100 * $thirdYouth / $totalCount;
        $fourProsent = $totalCount == 0 ? 0 : 100 * $fourYouth / $totalCount;

        $youthList = [
            [ 'youth' => '25-34', 'value' => $firstYouth, 'color' => '#2422e0', 'protsent' => round( $firstProsent,0) ],
            [ 'youth' => '18-24', 'value' => $secondYouth, 'color' => '#22e04a', 'protsent' => round( $secondProsent,0)],
            [ 'youth' => '45-54', 'value' => $thirdYouth, 'color' => '#e09322', 'protsent' => round( $thirdProsent,0)],
            [ 'youth' => 'Младше 18', 'value' => $fourYouth, 'color' => '#cb56b2', 'protsent' => round( $fourProsent,0)],
        ];

        $cityResult = [];
        foreach ($city as $value) {
            if($value['cityname'] == null) $name = '(Не заполнено)';
            else $name = $value['cityname'];
            $cityResult [] = [
                'cityname' => $name,
                'count' => $value['count'],
                'color' => Polls::getColorName(),
            ];
        }

        $man = 0;
        $woman = 0;
        foreach ($answers as $value) {
            if($value->user->gender == 1) $man++;
            if($value->user->gender == 0) $woman++;
        }
        $genderCount = $man + $woman;

        $genderResult = [];
        if($man == 0) $protsent = 0;
        else $protsent = 100 * $man / $genderCount;
        $genderResult [] = [
            'gender' => 1,
            'genderTitle' => 'Мужчина',
            'count' => $man,
            'protsent' => round($protsent,0),
            'color' => '#EE7F1A',
        ];

        if($woman == 0) $protsent = 0;
        else $protsent = 100 * $woman / $genderCount;
        $genderResult [] = [
            'gender' => 0,
            'genderTitle' => 'Женщина',
            'count' => $woman,
            'protsent' => round($protsent,0),
            'color' => '#E05022',
        ];

        $proffCount = 0;  $profResult = []; $proff = 0; $noProff = 0;
        foreach ($answers as $answer) {
            $proffCount++;
            $spec = $answer->user->getSpecialisationList();
            if(in_array($answer->poll->category_id, $spec)) $proff++;
            else $noProff++;
        }

        if($noProff == 0) $protsent = 0;
        else $protsent = 100 * $noProff / $proffCount;

        $profResult [] = [
            'profi_status' => 0,
            'profiTitle' => 'Не специалист',
            'count' => $noProff,
            'protsent' => round($protsent,0),
            'color' => '#E05022',
        ];

        if($proff == 0) $protsent = 0;
        else $protsent = 100 * $proff / $proffCount;

        $profResult [] = [
            'profi_status' => 1,
            'profiTitle' => 'Специалист',
            'count' => $proff,
            'protsent' => round($protsent,0),
            'color' => '#EE7F1A',
        ];

        return [
            'youthList' => $youthList,
            'likeCount' => $likeCount,
            'totalAnswerCount' => $totalAnswerCount,
            'chatCount' => $chatCount,
            'shareCount' => (string)$this->share_count,
            'qrCount' => (string)$this->qr_count,
            'proffStatus' => $profResult,
            'gender' => $genderResult,
            'cityList' => $cityResult,
        ];
    }

    public static function getSearchList($search, $page)
    {
        $query = "SELECT * FROM ".Polls::tableName()." where question LIKE :param";
        $resultPoll = Polls::findBySql($query, [':param' => $search.'%'])->all();

        //return $result;
        $result = [];
        foreach ($resultPoll as $poll) $result [] = $poll->id;

        $query = "SELECT * FROM ".PollCategory::tableName()." where name LIKE :param";
        $categoryList = PollCategory::findBySql($query, [':param' => $search.'%'])->all();

        $polls = Polls::find()->all();
        //$result = [];
        foreach ($categoryList as $category) {
            foreach ($polls as $poll) {
                $array = explode(',', $poll->category_id);
                if (in_array($category->id, $array)) $result [] = $poll->id;
            }
        }

        //return $result;
        $query = Polls::find()->where(['id' => $result])->orderBy(['date_cr' => SORT_DESC, 'id' => SORT_DESC]);
        $siteName = \Yii::$app->params['siteName'];
        $defaultPageSize = \Yii::$app->params['defaultPageSize'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize, //set page size here
                'page' => $page,
            ]
        ]);
        
        return Polls::sendSearchPollList($dataProvider, $page, $user_id = null, $search, $query);
    }

    public static function sendSearchPollList($dataProvider, $page, $user_id = null, $search, $query)
    {   
        if($dataProvider->getCount() == 0) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(204);
            return ['error' => "So'rovnomalar mavjud emas"];
        }

        $siteName = Yii::$app->params['siteName'];
        $result = []; $vaqt = 0;
        foreach ($dataProvider->getModels() as $poll) {
            $items = []; $vaqt++;
            $pollItems = PollItems::find()->where(['poll_id' => $poll->id])->all();
            if(!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $poll->user_id) $edit = true;
            else $edit = false;

            if(!Yii::$app->user->isGuest && Like::find()->where(['user_id' => Yii::$app->user->identity->id])->one() != null ) $like = true;
            else $like = false;

            foreach ($pollItems as $item) {
                $items [] = [
                    'id' => $item->id,
                    'option' => $item->option,
                    'percent' => $item->getCount(),
                    'image' => $item->getImage(),
                    'avatars' => $item->getSelectedUsersAvatar(),
                ];
            }
            $result [] = [
                'userId' => $poll->user->id,
                'userFIO' => $poll->user->getFIO(),
                'userName' => $poll->user->username,
                'userImage' => $poll->user->getImage(),
                'pollId' => $poll->id,
                'edit' => $edit,
                'like' => $like,
                'pollUrl' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollEdit' => "{$siteName}/v1/profil/edit-poll?id={$poll->id}",
                'pollStatistic' => "{$siteName}/v1/polls/statistic?id={$poll->id}",
                'pollComment' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollQrCode' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollShare' => "{$siteName}/v1/polls/item?id={$poll->id}",
                'pollСomplaint' => "{$siteName}/v1/polls/complaint?id={$poll->id}",
                'pollLikeCount' => Like::find()->where(['poll_id' => $poll->id])->count(),
                'pollType' => $poll->type,
                'pollTypeText' => $poll->getType()[$poll->type],
                'pollAnswerCount' => $poll->pollAnswerCount(),
                'pollCategory' => 'vaqtinchalik category', //$poll->getCategoryList()[$poll->category_id],
                'pollVisibility' => $poll->visibility, //$poll->getVisibility()[$poll->visibility],
                'pollTerm' => $poll->term, //$poll->getTerm()[$poll->term],
                'pollViewComment' => $poll->view_comment == 2 ? false : true,
                'pollHashtags' => $poll->hashtags,
                'pollCrown' => $vaqt == 1 ? true : false,
                'pollPublications' => $poll->publications,
                'pollEndDate' => $poll->date_cr != null ? date('d.m.Y', strtotime($poll->date_cr)) : null,
                'pollQuestion' => $poll->question,
                'pollImage' => $poll->getImage(),
                'disableCard' => $poll->disableCard(),
                'items' => $items,
            ];
        }

        $next = Polls::getNextPage($user_id,$page, $query);
        if($next != null) $next .= '&search='.$search;

        $previous = Polls::getOldPage($user_id,$page, $query);
        if($previous != null) $previous .= '&search='.$search;

        $polls = [
            'count' => $dataProvider->getCount(),
            'next' => $next, //Polls::getNextPage($user_id,$page),
            'previous' => $previous, //Polls::getOldPage($user_id,$page),
            'result' => $result,
        ];
        return $polls;
    }
}
