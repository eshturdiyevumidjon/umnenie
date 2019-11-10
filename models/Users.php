<?php

namespace app\models;


use Yii;
use yii\helpers\ArrayHelper; 
   
/**
 * This is the model class for table "users".
 * 
 * @property int $id
 * @property int $type Роль пользователя
 * @property string $facebook_user_id Регистрация Facebook
 * @property string $vk_user_id Регистрация VK
 * @property string $registry_date Дата регистрации
 * @property string $foto Аватар/ Фото профиля/ Логотип
 * @property string $logo Фото – обложка / брендированный фон
 * @property string $comments О себе
 * @property int $gender Пол
 * @property string $facebook Facebook
 * @property string $telegram Telegram
 * @property string $twitter Twitter
 * @property string $site Ссылка на сайт
 * @property string $email Email
 * @property int $category_id Категория
 * @property string $phone Телефон
 * @property string $address Страна/Город
 * @property string $fio Ф.И.О
 * @property string $specialization_id Специализация
 * @property string $username Имя пользователя
 * @property string $password Пароль
 * @property string $birthday Дата рождения
 * @property string $org_name Название организации
 * @property string $factual_address Фактический адрес
 * @property string $mobile_phone Мобильный номер для клиентов
 *
 * @property Answers[] $answers
 * @property BlockUser[] $blockUsers
 * @property BlockUser[] $blockUsers0
 * @property Chat[] $chats
 * @property Chat[] $chats0
 * @property Complaints[] $complaints
 * @property Polls[] $polls
 * @property SubscribeToPoll[] $subscribeToPolls
 * @property SubscribeToUser[] $subscribeToUsers
 * @property SubscribeToUser[] $subscribeToUsers0
 * @property Subscribes[] $subscribes
 * @property Subscribes[] $subscribes0
 * @property PollCategory $category
 */
class Users extends \yii\db\ActiveRecord
{
    public $new_password;
    public $retry_password;
    public $other_foto;
    public $other_image;

    Const EXPIRE_TIME = 86400; //token expiration time, 1 days valid

    public static function tableName()
    {
        return 'users'; 
    }

    public function rules()
    {
        return [
            [['type','gender', 'expire_at','verified','profi_status'], 'integer'],
            [['email', 'username', 'phone'], 'unique'],
            ['email', 'email'],
            [['registry_date','birthday'], 'safe'],
            [['comments','address','factual_address', 'new_password'], 'string'],
            [['facebook_user_id', 'vk_user_id'], 'string', 'max' => 500],
            [['username','password','phone','foto','fio', 'facebook', 'telegram','twitter','email','org_name','site','mobile_phone','logo', 'retry_password', 'access_token', 'google_user_id', 'sms_code'], 'string', 'max' => 255],
            // ['category_id', 'validateCategory'],
            [['other_image'], 'file'],
            [['other_foto'], 'file'],
            // ['specialization_id', 'validateSpecialization'],
            [['password', 'type', 'username'], 'required'],
            [['fio'], 'required', 'when' => function() {
                   if($this->type == 1) return TRUE;
                   else return FALSE;
            }],
            [['org_name'], 'required', 'when' => function() {
                   if($this->type == 2) return TRUE;
                   else return FALSE;
            }],
            [['password','retry_password'],'validatePasswords'],
            ['username', 'match',  'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Ваше имя пользователя может содержать только буквенно-цифровые символы, символы подчеркивания и тире'],
        ];
    }

    public function validatePasswords($attribute)
    { 
        if($this->isNewRecord && $this->password != $this->retry_password) {
            $this->addError($attribute, "«Новый пароль» и «Подтвердите новый пароль» не совпадают");    
        }     
    }
 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //---------------- Общий и Администратор проекта --------
            'type' => 'Роль пользователя',
            'facebook_user_id' => 'facebook_user_id',
            'vk_user_id' => 'vk_user_id',
            'google_user_id' => 'google_user_id',
            'registry_date' => 'Регистрация дата',
            'foto' => 'Аватар',
            'other_foto' => 'Аватар',
            'logo' => 'Фото – обложка',
            'other_image' => 'Фото – обложка ',
            'comments' => 'О себе',
            'gender' => 'Пол',
            'facebook' => 'Facebook',
            'telegram' => 'Telegram',
            'twitter' => 'Twitter',
            'site' => 'Ссылка на сайт',
            'email' => 'Email',
            'category_id' => 'Категория',
            'phone' => 'Телефон',
            'address' => 'Страна/Город',
            'fio' => 'Ф.И.О',
            'specialization_id' => 'Специализация',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'new_password' => 'Новый пароль',
            'access_token' => 'Access Token',
            'expire_at' => 'Token expiration time', 
            'verified' => 'Утвержденный',
            'profi_status' => 'Cтатус профи',
            //------------------- Физическое лицо --------------------                      
            'birthday' => 'Дата рождения',
            //------------------- Юридическое лицо ---------------------            
            'org_name' => 'Название организации',
            'factual_address' => 'Фактический адрес',
            'mobile_phone' => 'Мобильный номер для клиентов',
            'sms_code' => 'sms_code',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->verified = 0;
            $this->profi_status = 0;
            $this->registry_date = date('Y-m-d');
            $user = Yii::$app->user->identity;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->access_token = Yii::$app->getSecurity()->generateRandomString();
            $this->expire_at = time() + $this::EXPIRE_TIME;
        }

        if($this->birthday != null) $this->birthday = date('Y-m-d', strtotime($this->birthday));
        if($this->new_password != null) $this->password = Yii::$app->security->generatePasswordHash($this->new_password);
        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */

    public function beforeDelete()
    {
        $like = Like::find()->where(['user_id' => $this->id])->all();
        foreach ($like as $value) {
            $value->delete();
        }
        
        $answer = Answers::find()->where(['user_id' => $this->id])->all();
        foreach ($answer as $value) {
            $value->delete();
        }

        $blockuser = BlockUser::find()->where(['user_from' => $this->id])->all();
        foreach ($blockuser as $value) {
            $value->delete();
        }

        $blockuser = BlockUser::find()->where(['user_to' => $this->id])->all();
        foreach ($blockuser as $value) {
            $value->delete();
        }

        $chats = Chat::find()->where(['from' => $this->id])->all();
        foreach ($chats as $value) {
            $value->delete();
        }

        $chats = Chat::find()->where(['to' => $this->id])->all();
        foreach ($chats as $value) {
            $value->delete();
        }

        $complaints = Complaints::find()->where(['user_id' => $this->id])->all();
        foreach ($complaints as $value) {
            $value->delete();
        }


        $polls = Polls::find()->where(['user_id' => $this->id])->all();
        foreach ($polls as $value) {
            $value->delete();
        }

        $polls = Polls::find()->where(['referal_id' => $this->id])->all();
        foreach ($polls as $value) {
            $value->delete();
        }

        $subs = SubscribeToPoll::find()->where(['user_id' => $this->id])->all();
        foreach ($subs as $value) {
            $value->delete();
        }

        $subs = SubscribeToUser::find()->where(['user_id' => $this->id])->all();
        foreach ($subs as $value) {
            $value->delete();
        }

        $subs = SubscribeToUser::find()->where(['user_to' => $this->id])->all();
        foreach ($subs as $value) {
            $value->delete();
        }

        $subs = Subscribes::find()->where(['user_from' => $this->id])->all();
        foreach ($subs as $value) {
            $value->delete();
        }

        $subs = Subscribes::find()->where(['user_id' => $this->id])->all();
        foreach ($subs as $value) {
            $value->delete();
        }

        return parent::beforeDelete();
    }
    
    // public function getType()
    // {
    //     return ArrayHelper::map([
    //         ['id' => self::USER_TYPE_ADMIN, 'name' => 'Администратор',],
    //         ['id' => self::USER_TYPE_MANAGER, 'name' => 'Пользователь',],
    //     ], 'id', 'name');
    // }
    public function getType()
    {
        return ArrayHelper::map([
            ['id' => '1','type' => 'Физическое лицо',],
            ['id' => '2','type' => 'Юридическое лицо',],
            ['id' => '3','type' => 'Администратор проекта',], 
        ], 'id', 'type');
    }
    public function getTypes($id)
    {
        if($id == 1) return 'Физическое лицо';
        if($id == 2) return 'Юридическое лицо';
        if($id == 3) return 'Администратор проекта';
    }
    public function getTypeDescription()
    {
        switch ($this->type) {
            case 1: return "Физическое лицо";
            case 2: return "Юридическое лицо";
            case 3: return "Администратор проекта";
            default: return "Неизвестно";
        }
    }
    public function getGender()
    {
        return ArrayHelper::map([
            ['id' => 1, 'gender' => 'Мужской',],
            ['id' => 0, 'gender' => 'Женский',],
        ], 'id', 'gender');
    }
    public function getGenders($id)
    {
        if($id == 1) return 'Мужской';
        if($id == 0) return 'Женский';
    }

    public function getProffStatus()
    {
        if($this->profi_status == 1) return 'Специалист';
        else return 'Не специалист';
    }
    public function getCategoryList()
    {
        $offices = PollCategory::find()->all();
        return ArrayHelper::map($offices, 'id', 'name');
    }

    public function getCategoriesList()
    {
        $array = explode(',', $this->category_id);
        $cat = PollCategory::find()->where(['in', 'id', $array])->all();
        $result = [];
        foreach ($cat as $value) {
            $result [] = $value->id;
        }

        if(count($result) == 0){
            $result = $this->getCatIdList();
        }
        return $result;
    }

    public function getCatIdList()
    {
        $cat = PollCategory::find()->all();
        $result = [];
        foreach ($cat as $value) {
            $result [] = $value->id;
        }
        return $result;
    }

    public function getSpecialisationList()
    {
        $array = explode(',', $this->specialization_id);
        $spec = PollCategory::find()->where(['in', 'id', $array])->all();
        $result = [];
        foreach ($spec as $value) {
            $result [] = $value->id;
        }
        return $result;
    }

    public function getCategoryName()
    {
        $array = explode(',', $this->category_id);
        $result = "";
        foreach ($array as $value) {
            $cat = PollCategory::findOne($value);
            if($cat != null) $result .= $cat->name.';<br>';
        }
        return $result;
    }

    public function getSpecialisationName()
    {
        $array = explode(',', $this->specialization_id);
        $result = "";
        foreach ($array as $value) {
            $cat = PollCategory::findOne($value);
            if($cat != null) $result .= $cat->name.';<br>';
        }
        return $result;
    }

    public function getPollCategory()
    {
        return ArrayHelper::map(PollCategory::find()->all(), 'id', 'name');
    }
    public function validateCategory($attribute, $params)
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
    }

    public function getSpecializations()
    {
        return ArrayHelper::map(PollCategory::find()->all(), 'id', 'name');
    }

    public function getSpecializations1()
    {
        $category = PollCategory::find()->all();
        return ArrayHelper::map($category, 'id', 'name');
    }

    /*public function validateSpecialization($attribute, $params)
    {
        $specialization = Specialization::find()->where(['id'=>$this->specialization_id])->one();
        if (!isset($specialization)){
            $specialization = new Specialization();            
            $specialization->name = $this->specialization_id;            
            if ($specialization->save()){
                $this->specialization_id = $specialization->id;
            }else{
                $this->addError($attribute,"Не создано новая cпециализация");
                echo "<pre>".print_r($specialization,true)."</pre>";
            }
        }
    }*/
    
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getFIO()
    {
        if($this->type == 2) {
            $userFIO = $this->org_name;
        }
        else{
            $userFIO = $this->fio;
        }
        return $userFIO;
    }
    
    public function getImage()
    {
        $adminSiteName = Yii::$app->params['adminSiteName'];
        /*if($this->type == 2) {
            if($this->logo == null) $userImage = "{$adminSiteName}/img/no_image.jpg";
            else $userImage = "{$adminSiteName}/uploads/user/logo/{$this->logo}";
        }
        else{*/
            if($this->foto == null) $userImage = "{$adminSiteName}/img/no_user.jpg";
            else $userImage = "{$adminSiteName}/uploads/user/foto/{$this->foto}";
        /*}*/
        return $userImage;
    }

    public function getBackgroundImage()
    {
        $adminSiteName = Yii::$app->params['adminSiteName'];
        if($this->logo == null) $userImage = "{$adminSiteName}/img/default_background.jpg";
        else $userImage = "{$adminSiteName}/uploads/user/logo/{$this->logo}";

        return $userImage;
    }

    public function getCategoryNames()
    {
        //$adminSiteName = Yii::$app->params['adminSiteName'];
        $array = explode(',', $this->category_id);
        $result = [];
        foreach ($array as $value) {
            $category = PollCategory::findOne($value);
            if($category != null) $result [] = $category->id;
        }
        return $result;
    }

    public function getSpesializationNames()
    {
        //$adminSiteName = Yii::$app->params['adminSiteName'];
        $array = explode(',', $this->specialization_id);
        $result = [];
        foreach ($array as $value) {
            $spes = PollCategory::findOne($value);
            if($spes != null) $result [] = $spes->id;
        }
        return $result;
    }

    public function getUserCabinetLink()
    {
        $siteName = Yii::$app->params['siteName'];
        $link = "{$siteName}/v1/polls/user-profil?user_id={$this->id}";
        return $link;
    }

    public function getSubscribersDataprovider()
    {
        $subsearchModel = new SubscribeToUserSearch(['user_to' => $this->id]);
        $subdataProvider = $subsearchModel->search(Yii::$app->request->queryParams);
        return $subdataProvider;
    }

    public function getSubscriptionsDataprovider()
    {
        $subsearchModel2 = new SubscribeToUserSearch(['user_id' => $this->id]);
        $subdataProvider2 = $subsearchModel2->search(Yii::$app->request->queryParams);
        return $subdataProvider2;
    }

    public function getUsersMinValues()
    {
         $result = [
            'userId' => $this->id,
            'userType' => $this->type,
            'userFIO' => $this->getFIO(),
            'userName' => $this->username,
            'userImage' => $this->getImage(),
            'userPhone' => $this->phone!=="" ? $this->phone : null,
            'access_token' => $this->access_token,
        ];
        return $result;
    }

    public function getUsersProfilValues()
    {
        $social_networks = [];
        $isBlocked = false;
        $isFollow = false;
        $array = explode(' ',\Yii::$app->getRequest()->getHeaders()['Authorization']);
        if(isset($array[1])) $nowUser = User::findIdentityByAccessToken($array[1]);
        else $nowUser = null;

        if($nowUser != null) { 
            $model = BlockUser::find()->where(['user_from' => $nowUser->id, 'user_to' => $this->id])->one();
            if($model != null) $isBlocked = true;

            $model = SubscribeToUser::find()->where(['user_id' => $nowUser->id, 'user_to' => $this->id])->one();
            if($model != null) $isFollow = true;
        }

        if($this->facebook != null) $social_networks  += ['facebook' => $this->facebook];
        if($this->telegram != null) $social_networks  += ['telegram' => $this->telegram];
        if($this->twitter != null) $social_networks  += ['twitter' => $this->twitter];
        if($this->site != null) $social_networks  += ['site' => $this->site];

        $result = [
            'userId' => $this->id,
            'userFIO' => $this->getFIO(),
            'userName' => $this->username,
            'userImage' => $this->getImage(),
            'userBackground' => $this->getBackgroundImage(),
            'userType' => $this->type,
            'userTypeName' => $this->getTypeDescription(),
            'userRegistryDate' => $this->registry_date != null ? date('d.m.Y', strtotime($this->registry_date)) : null,
            'userComments' => $this->comments,
            'userGender' => $this->getGenders($this->gender),
            'social_networks' => $social_networks,
            'facebook' => $this->facebook,
            'telegram' => $this->telegram,
            'twitter' => $this->twitter,
            'site' => $this->site,
            'email' => $this->email,
            'isBlocked' => $isBlocked,
            'isFollow' => $isFollow,
            'org_name' => $this->org_name,
            'factual_address' => $this->factual_address,
            'mobile_phone' => $this->mobile_phone,
            //'category_id' => $this->category_id,
            //'categoryNames' => $this->getCategoryNames(),
            'phone' => $this->phone,
            'address' => $this->address,
            //'specialization_id' => $this->specialization_id,
            //'specializationNames' => $this->getSpesializationNames(),
            //'verified' => $this->verified,
            //'profi_status' => $this->profi_status,
            'birthday' => $this->birthday != null ? date('Y-m-d', strtotime($this->birthday)) : null,
            'mobile_phone' => $this->mobile_phone,
            //'expire_at' => $this->expire_at,
            //'access_token' => $this->access_token,
            'subscriptionCount' => count($this->getSubscriptionsDataprovider()->getModels()),
            'subscribersCount' => count($this->getSubscribersDataprovider()->getModels()),
        ];
        return $result;
    }

    public function getUsersAllValues()
    {
        $social_networks = [];
        if($this->facebook != null) $social_networks  += ['facebook' => $this->facebook];
        if($this->telegram != null) $social_networks  += ['telegram' => $this->telegram];
        if($this->twitter != null) $social_networks  += ['twitter' => $this->twitter];
        if($this->site != null) $social_networks  += ['site' => $this->site];
        
        $result = [
            'userId' => $this->id,
            'userFIO' => $this->getFIO(),
            'userName' => $this->username,
            'userImage' => $this->getImage(),
            'userBackground' => $this->getBackgroundImage(),
            'userType' => $this->type,
            'userTypeName' => $this->getTypeDescription(),
            'userRegistryDate' => $this->registry_date != null ? date('d.m.Y', strtotime($this->registry_date)) : null,
            'userComments' => $this->comments,
            'userGender' => $this->gender, //$this->getGenders($this->gender),
            'social_networks' => $social_networks,
            'facebook' => $this->facebook,
            'telegram' => $this->telegram,
            'twitter' => $this->twitter,
            'site' => $this->site,
            'org_name' => $this->org_name,
            'factual_address' => $this->factual_address,
            'mobile_phone' => $this->mobile_phone,
            'email' => $this->email,
            'category_id' => $this->getCategoryNames(),
            'categoryNames' => $this->category_id,
            'phone' => $this->phone,
            'userPhone' => $this->phone!=="" ? $this->phone : null,

            'address' => $this->address,
            'specialization_id' => $this->getSpesializationNames(),
            'specializationNames' => $this->specialization_id,
            'verified' => $this->verified,
            'profi_status' => $this->profi_status,
            'birthday' => $this->birthday != null ? date('Y-m-d', strtotime($this->birthday)) : null,
            'mobile_phone' => $this->mobile_phone,
            'expire_at' => $this->expire_at,
            'access_token' => $this->access_token,
            'subscriptionCount' => count($this->getSubscriptionsDataprovider()->getModels()),
            'subscribersCount' => count($this->getSubscribersDataprovider()->getModels()),
        ];
        return $result;
    }

    public function getSubscriptions()
    {
        $subscription = [];
        $subdataProvider2 = $this->getSubscriptionsDataprovider();
        foreach ($subdataProvider2->getModels() as $value) {
            $subscription [] = [
                'avatar' => $value->userTo->getImage(),
                'userFIO' => $value->userTo->getFIO(),
                'userName' => $value->userTo->username,
                'user_id' => $value->userTo->id,
            ];
        }
        return $subscription;
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockUsers()
    {
        return $this->hasMany(BlockUser::className(), ['user_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockUsers0()
    {
        return $this->hasMany(BlockUser::className(), ['user_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats0()
    {
        return $this->hasMany(Chat::className(), ['to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaints::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolls()
    {
        return $this->hasMany(Polls::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferals()
    {
        return $this->hasMany(Polls::className(), ['referal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribeToPolls()
    {
        return $this->hasMany(SubscribeToPoll::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribeToUsers()
    {
        return $this->hasMany(SubscribeToUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribeToUsers0()
    {
        return $this->hasMany(SubscribeToUser::className(), ['user_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribes()
    {
        return $this->hasMany(Subscribes::className(), ['user_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribes0()
    {
        return $this->hasMany(Subscribes::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(PollCategory::className(), ['id' => 'category_id']);
    }
}
