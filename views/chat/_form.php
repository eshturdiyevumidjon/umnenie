<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['class'=>"form-horizontal", 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data'] ]); ?>

    <div class="content-frame">                                    
        <!-- START CONTENT FRAME TOP -->
        <div class="content-frame-top">
            <div class="page-title">                    
                <h2>
                    <span>
                        <?= Html::a('<i style="font-size: 20px;" class="fa fa-arrow-left"></i> ', ['/chat/index'],
                            ['data-pjax'=>'0','title'=> 'Назадь', 'class'=>'btn btn-info']) ?>
                    </span>
                    &nbsp; <span class="fa fa-pencil"></span> Написать
                </h2>
            </div>                         
        </div>
        <!-- END CONTENT FRAME TOP -->
        <!-- START CONTENT FRAME LEFT -->
        <div class="content-frame-left" style="height: 748px;">
            <?= $this->render('left', []) ?>
        </div>
        <!-- END CONTENT FRAME LEFT -->
        <!-- START CONTENT FRAME BODY -->
        <div class="content-frame-body" style="height: 808px;">
            <div class="block">                            
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$model->getAttributeLabel('users')?></label>
                    <div class="col-md-10">
                        <?= $form->field($model, 'users')->widget(kartik\select2\Select2::classname(), [
                            'data' => $model->getUsersList(),
                            'size' => kartik\select2\Select2::SMALL,
                            'language' => 'ru',
                            'options' => ['placeholder' => 'Выберите',],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ])->label(false);
                        ?>
                        <div class="tags_clear"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$model->getAttributeLabel('title')?></label>
                    <div class="col-md-10">                                        
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                        <div class="tags_clear"></div>
                    </div>                                
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$model->getAttributeLabel('files')?></label>
                    <div class="col-md-10">                                        
                        <?= $form->field($model, 'files')->fileInput()->label(false); ?>
                        <div class="tags_clear"></div>
                    </div>                                
                </div>
                <div class="form-group">
                    <div class="col-md-12">    
                        <br>
                        <?= $form->field($model, 'text')->textarea(['class' => 'summernote_email'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <button class="btn btn-danger"><span class="fa fa-envelope"></span> Отправить</button>
                        </div>                                    
                    </div>
                </div>
            </div>                        
        </div>
        <!-- END CONTENT FRAME BODY -->
    </div>

<?php ActiveForm::end(); ?>