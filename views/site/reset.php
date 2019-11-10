<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Settings;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\authclient\widgets\AuthChoice;
use yii\authclient\clients\GoogleOpenId;
$this->title = 'Востановить пароль';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

?>

<div  class="login-container lightmode">
    <div class="login-box animated fadeInDown">
        <center><h1 style="color:#fff;"><?=Yii::$app->name?></h1></center><br>
    
        <div class="login-body" style="background: rgba(90, 124, 199, 0.2)">
            <p class="login-box-msg">Введите данные для востановления пароля</p><br>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false], $options = ['class' => 'margin-bottom-0']); ?>

            
            <div class="row" >
              <div class="col-md-12">
                      <?= $form
                          ->field($model, 'email', $fieldOptions1)
                          ->label(false)
                          ->textInput(['placeholder' => $model->getAttributeLabel('email'), 'class' => 'form-control']) ?>
              </div>
           </div><br>
            <div class="row">
                <div class="col-md-4">
                    <?= Html::a('Назад', ['/site/login'],['style' => 'width:100%;border-radius: 5px;','class' => 'btn btn-default btn-block', 'name' => 'login-button'])?>
                </div>
                <div class="col-md-8">
                    <?= Html::submitButton('Востановить', ['style' => 'width:100%;border-radius: 5px;','class' => 'btn btn-info', 'name' => 'login-button']) ?>
                </div>
             </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


