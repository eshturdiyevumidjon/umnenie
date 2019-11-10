<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
use unclead\multipleinput\MultipleInput;/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data']]); ?>
     <div class="row">
            <div class="col-md-4"> 
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 col-xs-2">
                <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"> 
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $model->isNewRecord ? $form->field($model, 'password')->textInput(['maxlength' => true]) : $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                            'data' => $model->getCategoryList(),
                            'options' => ['placeholder' => 'Выберите ...'],
                            'size' =>'sm',
                            'pluginEvents' =>'',
                            'pluginOptions' => [
                                'tags' => true,
                                'allowClear' => true,
                            ],
                        ]);?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"> 
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+\9\98 99 999-99-99','options' => ['placeholder' => '+99890 000-00-00','class'=>'form-control',]]); ?> 
            </div>
            <div class="col-md-3 col-xs-3">
                <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3 col-xs-3">
                <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3 col-xs-3">
                <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-3">
                <?= $form->field($model, 'address')->textarea(['rows' => 2]); ?>
            </div>
            <div class="col-md-6 col-xs-3">
                <?= $form->field($model, 'comments')->textarea(['rows' => 2]); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>

