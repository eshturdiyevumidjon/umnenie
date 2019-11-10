<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use kartik\file\FileInput;
use unclead\multipleinput\MultipleInput;

$model->foto != null ? $path = '/uploads/user/foto/' . $model->foto : $path = '/img/no_image.jpg';
$model->logo != null ? $path1 = '/uploads/user/logo/' . $model->logo : $path1 = '/img/no_image.jpg';

$individual = false;
$entity = false;
if($model->type == 1 ) $individual = true;
if($model->type == 2) $entity = true;

$array = explode(',', $model->category_id);
$model->category_id = $array;

$array = explode(',', $model->specialization_id);
$model->specialization_id = $array;

?>
   
<div class="users-form">  

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4"> 
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'type')->label()->widget(\kartik\select2\Select2::classname(), [
                    'data' => $model->getType(),
                    'hideSearch' => true,
                    'size' =>'sm', 
                    'options' => [
                        'placeholder' => 'Выберите ...',
                        'onchange'=>'
                            var type = $(this).val();
                            $("#individual").show();
                            $("#entity").show();
                            $("#administrator").show();
                            if(type == 1) 
                            {
                                $("#individual").show(); 
                                $("#entity").hide();
                            }
                            if(type == 2) 
                            {
                                $("#individual").hide(); 
                                $("#entity").show();
                            }
                            if(type == 3) 
                            {
                                $("#individual").hide(); 
                                $("#entity").hide();
                            }
                            //alert(type);
                            ' 
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?> 
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
                <?= $form->field($model, 'category_id')->widget(kartik\select2\Select2::classname(), [
                    'data' => $model->getPollCategory(),
                    'theme' => Select2::THEME_CLASSIC,
                    'options' => ['multiple' => true,'placeholder' => 'Выберите'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        //'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 1000,
                    ],
                ])?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 ">
                <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'specialization_id')->widget(kartik\select2\Select2::classname(), [
                'data' => $model->getSpecializations(),
                'theme' => Select2::THEME_CLASSIC,
                'options' => ['multiple' => true,'placeholder' => 'Выберите'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    //'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 1000,
                ],
            ])?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'gender')->label()->widget(\kartik\select2\Select2::classname(), [
                        'data' => $model->getGender(),
                        'size' =>'sm',
                        'options' => [
                            'placeholder' => 'Tanlang',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>  
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"> 
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+\9\98 99 999-99-99','options' => ['placeholder' => '+99890 000-00-00','class'=>'form-control',]]); ?> 
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'telegram')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'address')->textarea(['rows' => 2]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'comments')->textarea(['rows' => 2]); ?>
            </div>
        </div>
        
    </div>
</div>
<div class="row" id="individual" <?= $individual ? '' : 'style="display: none"' ?>>
    <div class="col-md-12" id="individual"> 
        <div class="row">
            <div class="col-md-12"> 
                <?= $form->field($model, 'birthday')->widget(
                    DatePicker::className(), [
                        'inline' => false,
                        'language' => 'ru',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                            'startView'=>'decade',
                        ]
                    ])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" id="entity" <?= $entity ? '' : 'style="display: none"' ?>> 
        <div class="row">
            <div class="col-md-6"> 
                <?= $form->field($model, 'org_name')->textInput(['maxlength' => true]) ?>
            </div>            
            <div class="col-md-6">
                <?= $form->field($model, 'mobile_phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+\9\98 99 999-99-99','options' => ['placeholder' => '+99890 000-00-00','class'=>'form-control',]]); ?> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'factual_address')->textarea(['rows' => 4]); ?>
            </div>
        </div>
    </div>
</div><br>
<div class="row" >
    <div class="col-md-5" style="margin-left:10px">
        <?= $form->field($model, 'verified')->checkbox(); ?>
    </div>
    <div class="col-md-4" style="margin-left:62px">
        <?= $form->field($model, 'profi_status')->checkbox(); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div id="commands_photo">
            <?= Html::img($path, [
                'style' => 'width:180px; height:180px;',
                //'class' => 'img-circle',
            ]) ?>
        </div>
        <?= $form->field($model, 'foto', ['inputOptions' =>['value' => $model->foto]])->fileInput(['accept' => 'image/*', 'class' => "poster23_image"]); ?>
    </div>
    <div class="col-md-4">
        <div id="commands_logo">
            <?= Html::img($path1, [
                'style' => 'width:180px; height:180px;',
                //'class' => 'img-circle',
            ]) ?>
        </div>
        <?= $form->field($model, 'logo', ['inputOptions' =>['value' => $model->logo]])->fileInput(['accept' => 'image/*', 'class' => "poster22_image"]); ?>
    </div>
</div>
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php
$this->registerJs(<<<JS

    var fileCollection = new Array();
    $(document).on('change', '.poster23_image', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:180px; height:180px;" src="'+e.target.result+'"> ';
                $('#commands_photo').html('');
                $('#commands_photo').append(template);
            };
        });
    });
JS
);
?>
<?php
$this->registerJs(<<<JS

    var fileCollection1 = new Array();
    $(document).on('change', '.poster22_image', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection1.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:180px; height:180px;" src="'+e.target.result+'"> ';
                $('#commands_logo').html('');
                $('#commands_logo').append(template);
            };
        });
    });
JS
);
?>