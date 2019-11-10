<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4 col-xs-2"> 
            <?= $form->field($model,'user_id')->dropDownList($model->getUsers(), ['prompt' => 'Выберите ... ']); ?>
        </div>
        <div class="col-md-4 col-xs-2"> 
            <?= $form->field($model,'poll_id')->dropDownList($model->getPolls(), ['prompt' => 'Выберите ... ']); ?>
        </div>
        <div class="col-md-4 col-xs-2"> 
            <?= $form->field($model,'poll_item_id')->dropDownList($model->getPollItems(), ['prompt' => 'Выберите ... ']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-6">
            <?= $form->field($model, 'comment')->textarea(['rows' => 4]); ?>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
