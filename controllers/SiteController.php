<?php

namespace app\controllers;

use Yii; 
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\ResetPasswordForm;
use app\models\PasswordForm;
use yii\web\NotFoundHttpException;
use app\models\Users; 

class SiteController extends Controller
{
    public $successUrl= 'Success';
    /**
     * {@inheritdoc}
     */ 
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'dashboard'],
                'rules' => [
                    [
                        'actions' => ['logout', 'dashboard'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback'=> [$this,'successCallback'],
            ],
        ];
    } 
    public function actionAvtorizatsiya()
    {
        if(isset(Yii::$app->user->identity->id))
        {
            return $this->redirect('/admin/default/error');
        }        
        else
        {
            Yii::$app->user->logout();
            $this->redirect(['login']);
        }
    }
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        $user = \common\modules\auth\models\User::find()->where(['email'=>$attributes['email']])->one();
        if(!empty($user)){
            Yii::$app->user->login($user);
        }else{
            $session=Yii::$app->session;
            $session['attributes']=$attributes;
            $this->successUrl=\yii\helpers\Url::to(['signup']);
        }
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionDashboard()
    {
        if (!Yii::$app->user->isGuest) { 
            //if(Yii::$app->user->identity->type == 3) 
            //hozircha bu punktni olib turamiz, lekin kelajakda iwlatiwimiz mumkin
            return $this->render('index');
        }else
        {
            return $this->redirect(['site/login']);
        }
    }
    public function actionPassword($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $users = Users::find()->All();
        $username = "";
        foreach ($users as $value) {
            if((md5(md5($value->id))) == $token)$username = $value->email; $id = $value->id;
        }
        if($username != "")
        {  
            $model = new PasswordForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate() ) 
            {
                $user = Users::find()->where(['id'=>$id])->one();
                $user->password = Yii::$app->security->generatePasswordHash($model->new_password);
                // $user->username ="salom";
                // echo "<pre>";
                // print_r($user->errors);
                // echo "</pre>";
                $user->save();

                return $this->redirect(['index']);
            }
            return $this->render('password', [
                'model' => $model,
            ]);
        }
        else
        {
             return $this->redirect(['error']);
        }
    }
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //$this->layout = 'main-login';

        $model = new RegisterForm();

        if($model->load(Yii::$app->request->post()) && $model->register())
        {
            //Yii::$app->session->setFlash('register_success', 'Регистрация прошла успешно. Пожалуйста, авторизируйтесь');
            $login_model = new LoginForm();
            $login_model->username = $model->login;
            $login_model->password = $model->password;
            if ($login_model->login()) {
                Users::setDefaultValues();
                return $this->goBack();
            }
            else return $this->redirect(['login']);
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    } 
    public function actionReset()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';

        $model = new ResetPasswordForm();

        if($model->load(Yii::$app->request->post()) && $model->reset())
        {
            Yii::$app->session->setFlash('register_success', 'Временная ссылка была отправлена на вашу электронную почту. Используйте для подтверждения');
            return $this->redirect(['login']);
        } else {
            return $this->render('reset', [
                'model' => $model,
            ]);
        }
    } 
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        $this->redirect(['login']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSetTheme()
    {
        $session = Yii::$app->session;
        if (isset($_POST['theme'])) $session['theme'] = $_POST['theme'];
    }

    public function actionSetThemeValues()
    {
        $session = Yii::$app->session;
        if (isset($_POST['st_head_fixed'])) $session['st_head_fixed'] = $_POST['st_head_fixed'];
        if (isset($_POST['st_sb_fixed'])) $session['st_sb_fixed'] = $_POST['st_sb_fixed'];
        if (isset($_POST['st_sb_scroll'])) $session['st_sb_scroll'] = $_POST['st_sb_scroll'];
        if (isset($_POST['st_sb_right'])) $session['st_sb_right'] = $_POST['st_sb_right'];
        if (isset($_POST['st_sb_custom'])) $session['st_sb_custom'] = $_POST['st_sb_custom'];
        if (isset($_POST['st_sb_toggled'])) $session['st_sb_toggled'] = $_POST['st_sb_toggled'];
        if (isset($_POST['st_layout_boxed'])) $session['st_layout_boxed'] = $_POST['st_layout_boxed'];
    }

    public function actionStHeadFixed()
    {
        $session = Yii::$app->session;
        if($session['st_head_fixed'] != null) return $session['st_head_fixed'];
        else return 0;
    }

    public function actionStSbFixed()
    {
        $session = Yii::$app->session;
        if($session['st_sb_fixed'] != null) return $session['st_sb_fixed'];
        else return 1;
    }

    public function actionStSbScroll()
    {
        $session = Yii::$app->session;
        if($session['st_sb_scroll'] != null) return $session['st_sb_scroll'];
        else return 1;
    }

    public function actionStSbRight()
    {
        $session = Yii::$app->session;
        if($session['st_sb_right'] != null) return $session['st_sb_right'];
        else return 0;
    }

    public function actionStSbCustom()
    {
        $session = Yii::$app->session;
        if($session['st_sb_custom'] != null) return $session['st_sb_custom'];
        else return 0;
    }

    public function actionStSbToggled()
    {
        $session = Yii::$app->session;
        if($session['st_sb_toggled'] != null) return $session['st_sb_toggled'];
        else return 0;
    }

    public function actionStLayoutBoxed()
    {
        $session = Yii::$app->session;
        if($session['st_layout_boxed'] != null) return $session['st_layout_boxed'];
        else return 0;
    }
}
 