<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Settings;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\authclient\widgets\AuthChoice;
use yii\authclient\clients\GoogleOpenId;

$this->title = 'Зарегистрироваться';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions4 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-earphone form-control-feedback'></span>"
];

$fieldOptions5 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-send form-control-feedback'></span>"
];
?> 

<div  class="login-container lightmode">
    <div class="login-box animated fadeInDown">
        <center><h1 style="color:#fff;"><?= Html::encode($this->title) ?></h1></center>
    <br>
        <div class="login-body" style="background: rgba(90, 124, 199, 0.2)">
            <p class="login-title">Введите данные авторизации</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
            <div class="row" >
                <div class="col-xs-12">
                    <?= $form
                        ->field($model, 'fio', $fieldOptions3)
                        ->label(false)
                        ->textInput(['placeholder' => 'ФИО']) ?>
                </div>
            </div><br>
            <div class="row" >
                <div class="col-xs-12">
                    <?= $form
                        ->field($model, 'telephone', $fieldOptions4)
                        ->label(false)
                        ->textInput(['placeholder' => 'Телефон']) ?>
                    </div>
            </div><br>
            <div class="row" >
                <div class="col-xs-12">
                    <?= $form
                        ->field($model, 'email', $fieldOptions1)
                        ->label(false)
                        ->textInput(['placeholder' => 'Логин']) ?>
                </div>
            </div><br>
            <div class="row" >
                <div class="col-xs-12">
                    <?= $form
                        ->field($model, 'password', $fieldOptions2)
                        ->label(false)
                        ->passwordInput(['placeholder' => 'Пароль']) ?>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12">
                    
                </div>
             </div>
             <div class="row">
                <div class="col-md-4">
                    <?= Html::a('Назад', ['/site/login'],['style' => 'width:100%;border-radius: 5px;','class' => 'btn btn-default btn-block', 'name' => 'login-button'])?>
                </div>
                <div class="col-md-8">
                    <?= Html::submitButton('Регистрировать', [ 'style' => 'width:100%;border-radius: 5px;', 'class' => 'btn btn-info btn-block', 'name' => 'login-button']) ?>
                </div>
             </div>
        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>







