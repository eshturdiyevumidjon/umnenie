<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */ 
/* @var $model app\models\Polls */
/* @var $form yii\widgets\ActiveForm */
$model->image != null ? $path = '/uploads/polls/' . $model->image : $path = '/img/no_image.jpg';
?> 
 
<div class="polls-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
            <div class="col-md-4"> 
                <?= $form->field($model,'user_id')->dropDownList($model->getUsers(), ['prompt' => 'Выберите ... ']); ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'category_id')->widget(kartik\select2\Select2::classname(), [
                    'data' => $model->getPollCategory(),
                    'theme' => Select2::THEME_CLASSIC,
                    'options' => [ /*'multiple' => true,*/ 'placeholder' => 'Выберите'],
                    'pluginOptions' => [
                        /*'allowClear' => true,*/
                        //'tags' => true,
                        //'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 1000,
                    ],
                ])?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model,'type')->dropDownList($model->getType(), ['prompt' => 'Выберите ... ']); ?>
           </div>
        </div>
        <div class="row">
            <div class="col-md-3"> 
                <?= $form->field($model,'status')->dropDownList($model->getStatus(), ['prompt' => 'Выберите ... ']); ?>
           </div>
            <div class="col-md-3"> 
                <?= $form->field($model,'visibility')->dropDownList($model->getVisibility(), ['prompt' => 'Выберите ... ']); ?>
            </div>
            <div class="col-md-3"> 
                <?= $form->field($model,'term')->dropDownList($model->getTerm(), ['prompt' => 'Выберите ... ']); ?>
            </div>
            <div class="col-md-3"> 
                <?= $form->field($model,'view_comment')->dropDownList($model->getViewComment(), ['prompt' => 'Выберите ... ']); ?>
                </div>
        </div>
        <div class="row">
            <div class="col-md-4"> 
                <?= $form->field($model, 'date_end')->widget(
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
            <div class="col-md-4"> 
                <?= $form->field($model, 'hashtags')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4"> 
                <?= $form->field($model, 'publications')->textInput(['maxlength' => true]) ?>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?= $form->field($model, 'question')->textarea(['rows' => 2]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-6">
                <div id="polls">
                    <?= Html::img($path, [
                        'style' => 'width:180px; height:180px;',
                        //'class' => 'img-circle',
                    ]) ?>
                </div>
                <?= $form->field($model, 'image', ['inputOptions' =>['value' => $model->image]])->fileInput(['accept' => 'image/*', 'class' => "poster_image"]); ?>
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
    $(document).on('change', '.poster_image', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:180px; height:180px;" src="'+e.target.result+'"> ';
                $('#polls').html('');
                $('#polls').append(template);
            };
        });
    });
JS
);
?>