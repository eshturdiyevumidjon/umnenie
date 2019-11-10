<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mailing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mailing-form" style="padding:20px;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    	<div class="col-md-8">
    		<input type="checkbox" name="yur" value="1"> Юр. лицо
    	</div>
    	<div class="col-md-4">
    		<input type="checkbox" name="fiz" value="1"> Физ. лицо
    	</div>
    </div>
    <hr>

    <div class="row">
    	<div class="col-md-12">
    		<?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>
    	</div>
    </div>

    <hr>

    <div class="row">
    	<div class="col-md-8">
    		<input type="checkbox" name="email" value="1"> E-mail
    	</div>
    	<div class="col-md-4">
    		<input type="checkbox" name="sms" value="1"> SMS
    	</div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
