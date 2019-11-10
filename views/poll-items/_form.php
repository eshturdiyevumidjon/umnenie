<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PollItems */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="poll-items-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-12 col-xs-6"> 
            <?= $form->field($model,'poll_id')->dropDownList($model->getPolls(), ['prompt' => 'Выберите ... ']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-6">
            <?= $form->field($model, 'option')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
	<div class="row">
        <div class="col-md-12 col-xs-6">
            <?= $form->field($model, 'other_image')->fileInput() ?>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
