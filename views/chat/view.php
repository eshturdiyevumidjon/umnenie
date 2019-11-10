<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);
?>
<div class="row"> 
    <div class="col-md-12">
        <b>Заголовок</b>
        <div class="panel">
            <div class="panel-body">
                 <?=$model->title?>
            </div>                                          
        </div>
    </div>
    <div class="col-md-12">
        <b>Текст</b>
        <div class="panel">
            <div class="panel-body">
                 <?=$model->text?>
            </div>                                          
        </div>
    </div>
</div>
    <?php if($model->file != null) {  ?>
        <div class="pull-left">
            <a class="fa fa-download" href=" <?=Url::toRoute(['/chat/download-file','id' => $model->id,])?>">Скачать</a>
        </div>
    <?php }?>
    
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>


