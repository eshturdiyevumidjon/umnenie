<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Settings;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\authclient\widgets\AuthChoice;
use yii\authclient\clients\GoogleOpenId;
$this->title = 'Авторизация';  

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div  class="login-container lightmode">
    <div class="login-box animated fadeInDown">
        <center><h1 style="color:#fff;"><?= Html::encode($this->title) ?></h1></center>
        <?php if(Yii::$app->session->hasFlash('register_success')): ?>
            <p>
                <div class="alert alert-success show m-b-0">
                    <span class="close" data-dismiss="alert">×</span>
                    <strong>Успех!</strong>
                    <?=Yii::$app->session->getFlash('register_success')?>
                </div>
            </p>
        <?php endif; ?>
        
    <!-- /.login-logo -->
    <br>
        <div class="login-body" style="background: rgba(90, 124, 199, 0.2)">
            <p class="login-title">Введите данные для входа</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                    <div class="row" >
                        <div class="col-xs-12">
                            <?= $form
                                ->field($model, 'username', $fieldOptions1)
                                ->label(false)
                                ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
                        </div>
                    </div><br>
                    <div class="row" >
                        <div class="col-xs-12">
                            <?= $form
                                ->field($model, 'password', $fieldOptions2)
                                ->label(false)
                                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                                <?= Html::submitButton('Вход', [ 'style' => 'width:100%;border-radius: 5px;', 'class' => 'btn btn-info btn-block', 'name' => 'login-button']) ?>
                        </div>
                     </div><br>
                     <div class="row" >
                        <div class="col-xs-7">
                            <?= Html::a('Востановить пароль', $url = '/site/reset', ['style'=>'color:red;','option' => 'value']); ?>
                        </div>
                        <div class="col-xs-4">
                            <?php/* Html::a('Зарегистрироваться', $url = '#', ['style'=>'color:red;margin-left:10px','option' => 'value']); */?>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12"><br>
                            <?php/* yii\authclient\widgets\AuthChoice::widget([
                                'baseAuthUrl' => ['site/auth']
                            ]);*/?>
                        </div>
                     </div>
                     <!-- <div class="login-logo">
                        <?php/*
                            
                            /////---------------------------------------VK---------------------------------------------------/////
                            $app_id = Settings::find()->where(['key' => 'vk_id_app'])->one()->value;
                            $my_url = Settings::find()->where(['key' => 'vk_api_callback'])->one()->value;
                            $dialog_url = 'https://oauth.vk.com/authorize?client_id='.$app_id.'&redirect_uri='.$my_url.'&response_type=code&display=page&scope=nohttps,groups,photos,friends,offline';
                            /////---------------------------------------FaceBook---------------------------------------------------//////
                            $client_id  = Settings::find()->where(['key' => 'facebook_client_id'])->one()->value;
                            $client_secret  = Settings::find()->where(['key' => 'facebook_client_secret'])->one()->value;
                            $redirect_uri  = Settings::find()->where(['key' => 'facebook_redirect_uri'])->one()->value;

                            $url = 'https://www.facebook.com/dialog/oauth';

                            $params = array(
                                'client_id'     => $client_id,
                                'redirect_uri'  => $redirect_uri,
                                'response_type' => 'code',
                                'scope'         => 'email,user_birthday'
                            );
                            $url_facebook = $url . '?' . urldecode(http_build_query($params));
                            //
                            echo Nav::widget([
                                'options' => ['class' => 'navbar-nav navbar-right'],
                                'items' => [
                                    [
                                        'label' => 'Войти через VK', 'url' => $dialog_url,
                                        // 'label' => 'Войти через FaceBook', 'url' => $url_facebook,
                                        
                                    ],
                                ],
                            ]);*/
                        ?>
                    </div> -->

        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


