<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\Users; 
use unclead\multipleinput\MultipleInput;
use kartik\tabs\TabsX;
use kartik\select2\Select2;
use johnitvn\ajaxcrud\CrudAsset; 

CrudAsset::register($this);

?>
<div id="ajaxCrudDatatable">
     <div class="box box-default">
        <div class="box-body" style="background-color: #ecf0f5;">


    <?php $form = ActiveForm::begin(['id' => 'job-form']); ?>
   
   <div class="row">
        <div class="col-md-12"> <br><br>   
            <span style="font-size:20px;"><center>Место работы</center></span>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-4"> 
        <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4"> 
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4"> 
            <?= $model->isNewRecord ? $form->field($model, 'password')->textInput(['maxlength' => true]) : $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"> 
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4"> 
            <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '(999)999-99-99','options' => ['placeholder' => '(000)000-00-00','class'=>'form-control',]]) ?>
        </div>
        <div class="col-md-4"> 
            <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-2">
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
        <div class="col-md-4 col-xs-2">
            <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 col-xs-2">
            <?= $form->field($model, 'mobile_phone')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '(999)999-99-99','options' => ['placeholder' => '(000)000-00-00','class'=>'form-control',]]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-6">
            <?= $form->field($model, 'address')->textarea(['rows' => 4]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-6">
            <?= $form->field($model, 'factual_address')->textarea(['rows' => 4]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-6">
            <?= $form->field($model, 'comments')->textarea(['rows' => 4]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-3">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>
        <div class="col-md-6 col-xs-3">
            <?= $form->field($model, 'logo')->fileInput() ?> 
        </div>
    </div>
    <?= $form->field($model, 'step')->hiddenInput()->label(false) ?>

    <!-- -->
    <?= $form->field($model, 'brand_name')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'email')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'org_name')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'factual_address')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'site')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'mobile_phone')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'logo')->hiddenInput()->label(false) ?>
    <!-- -->
    <div class="col-md-12">  <br>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "size" => "modal-lg",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>