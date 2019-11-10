<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;
use yii\widgets\LinkPager; 
use yii\widgets\ActiveForm;

$this->title = 'Все сообщения';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);

?>

<?php Pjax::begin(['enablePushState' => false, 'id' => 'inbox-pjax']) ?>   
<div class="content-frame" >                                    
    <div class="content-frame-top" >                        
        <div class="page-title">   
            <h2> 
                <span>
                    <?= Html::a('<i style="font-size: 20px;" class="fa fa-arrow-left"></i> ', ['/chat/index'],
                            ['data-pjax'=>'0','title'=> 'Назадь', 'class'=>'btn btn-info']) ?>
                </span>
                    &nbsp; <h2> Все сообщения <small></small></h2>
            </h2>              
        </div>         
    </div>   
     <div class="panel panel-default" style="overflow-x:auto;">
        <div class="row">
            <div class="col-md-12 col-xs-6">
                
                <?php if($dataProvider->getModels()!=null){ ?>
                <div class="messages messages-img" style="margin-top:5px">

                    <?php foreach ($dataProvider->getModels() as $model){
                    
                    ?>
                    <?php
                        $unread = ''; $mail = 'mail-info';

                        if($model->file != null) $file = '<a data-pjax="0" href="'.Url::toRoute(['/chat/download-file',"id" => $model->id]).'"' . '><div class="mail-attachments"><span class="fa fa-paperclip"></span> ' . $model->format_size(filesize('uploads/chat/'.$model->file)) .'</div></a>';
                        else $file = '';
                    ?>
                    <div id="ajaxCrudDatatable">
                        <?php if($model->from!=""){?>
                        
                            <div class="item"> 
                                <div class="image">
                                    <?php if ($model->userFrom->foto == '') {?>
                                        <img src="/extra/images/users/no-image.jpg" >
                                    <?php } else {?>
                                        <?= ($model->userFrom->foto)?Html::img('/uploads/user/foto/'.$model->userFrom->foto,['style'=>'min-width: 47px;min-height: 48px']):null;?>
                                    <?php }?>
                                </div>                                
                                <div class="text">
                                    <div class="heading">
                                        <a href="#"><?=$model->userFrom->fio?></a>
                                        
                                        <span class="date" style="margin-right:60px"><?= date( 'H:i d.m.y', strtotime($model->date_cr) ) ?></span>
                                        <?php Pjax::begin(['enablePushState' => false, 'id' => 'chat-pjax']) ?>
                                        <span class="date" style="margin-top:-20px">
                                            <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model->id], ['role'=>'modal-remote','title'=> 'Изменить', 'style' => 'color:red', 'class'=>' btn-xs'])?>
                                            &nbsp;&nbsp;&nbsp;<?= 
                                                 Html::a('<span class="glyphicon glyphicon-trash"></span>', ['close', 'id' => $model->id], [
                                                    'style'=>'color:red', 
                                                    'role'=>'modal-remote','title'=>'Удалить', 
                                                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                                          'data-request-method'=>'post',
                                                          'data-toggle'=>'tooltip',
                                                          'data-confirm-title'=>'Подтвердите действие',
                                                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                                                ]);
                                            ?>
                                        </span>
                                        <?php Pjax::end() ?> 
                                    </div>
                                    <div class="heading">
                                        <b><?=$model->title?></b><br>  
                                        <?=$model->text?>
                                        <span class="date"><?=$file?></span>
                                    </div>                                       
                                </div>
                            </div>
                        <?php } elseif($model->to!=""){?>
                            <div class="item"> 
                                <div class="image">
                                    <?php if ($model->userTo->foto == '') {?>
                                        <img src="/extra/images/users/no-image.jpg" >
                                    <?php } else {?>
                                        <?= ($model->userTo->foto)?Html::img('/uploads/user/foto/'.$model->userTo->foto,['style'=>'min-width: 47px;min-height: 48px']):null;?>
                                    <?php }?>
                                </div>                                
                                <div class="text">
                                    <div class="heading">
                                        <a href="#"><?=$model->userTo->fio?></a>
                                        <span class="date" style="margin-right:20px"><?= date( 'H:i d.m.y', strtotime($model->date_cr) ) ?></span>
                                        <?php Pjax::begin(['enablePushState' => false, 'id' => 'chat-pjax']) ?>
                                        <span class="date" style="margin-top:-20px">
                                            &nbsp;&nbsp;&nbsp;<?= 
                                                 Html::a('<span class="glyphicon glyphicon-trash"></span>', ['close', 'id' => $model->id], [
                                                    'style'=>'color:red',
                                                    'role'=>'modal-remote','title'=>'Удалить', 
                                                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                                          'data-request-method'=>'post',
                                                          'data-toggle'=>'tooltip',
                                                          'data-confirm-title'=>'Подтвердите действие',
                                                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                                                ]);
                                            ?>
                                        </span>
                                        <?php Pjax::end() ?> 
                                    </div>
                                    <div class="heading">
                                        <b><?=$model->title?></b><br>  
                                        <?=$model->text?> 
                                        <span class="date"><?=$file?></span>
                                    </div>                                       
                                </div>
                            </div>
                            
                        <?php } ?>
                        </div>
                    <?php } ?>
                    
                </div> 
                <div class="panel-footer">
                    <div class="panel panel-default push-up-10" id="chat-form">
                        <div class="panel-body panel-body-search">
                            <?php $form = ActiveForm::begin(); ?>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="msg" id="msg" placeholder="Введите текст...">
                                    <div class="input-group-btn">
                                        <button class="btn btn-success">Отправить</button>
                                    </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <span class="pull-right">
                        <?=LinkPager::widget(['pagination'=>$dataProvider->pagination,])?>                    
                    </span>
                </div> 
                <?php } else{?><br>
                <div class="messages messages-img">
                    <div class="item">
                        <div class="image">
                            <img src="/extra/images/users/no-image.jpg" alt="Dmitry Ivaniuk">
                        </div>                                
                        <div class="text">
                            <div class="heading">
                                <a>Нет чат на этой странице.</a>
                                <span class="date">00:00 00.00.0000</span>
                            </div>                                    
                            
                        </div>
                    </div>  
                </div> 
                <?php } ?>
            </div>  
        </div>                       
    </div>
    
</div>
<?php Pjax::end() ?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
