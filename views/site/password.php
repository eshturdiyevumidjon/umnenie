<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Изменить пароль';

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
        <div class="login-body" style="background: rgba(90, 124, 199, 0.2)">
            <p>Пожалуйста, введите новый пароль, чтобы обеспечить безопасность вашей информации.</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

                    <div class="row" >
                        <div class="col-xs-12">
                            <?= $form
                                ->field($model, 'password', $fieldOptions2)
                                ->label(false)
                                ->textInput(['placeholder' => 'Новый пароль']) ?>

                        </div>
                    </div><br>
                    <div class="row" >
                        <div class="col-xs-12">
                            <?= $form
                                ->field($model, 'new_password', $fieldOptions2)
                                ->label(false)
                                ->textInput(['placeholder' => 'Повторите пароль еще раз']) ?>

                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                                <?= Html::submitButton('Изменить', ['style' => 'width:100%;border-radius: 5px;', 'class' => 'btn btn-info btn-block', 'name' => 'login-button']) ?>
                        </div>
                     </div><br>
        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
