<?php
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset; 
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\LinkPager;
use app\models\Answers; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\PollCategory;

$this->title = 'Информация';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this); 

?>
<div class="faq-index" style="overflow-x:auto;">
    <div class="panel panel-default tabs" style="min-width:480px">                          
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab-first" role="tab" data-toggle="tab">Информация</a></li>
            <li><a href="#tab-second" role="tab" data-toggle="tab">Подписчики</a></li>
            <li><a href="#tab-three" role="tab" data-toggle="tab">Лайк</a></li>
        </ul>
        <div class="panel-body tab-content">
            <div class="tab-pane active" id="tab-first">
                <div class="panel panel-warning" style="min-width:450px">
                    <div class="panel-heading ui-draggable-handle">
                        <div style="margin-top: 5px;margin-right:5px">
                        <ul class="panel-controls">
                            <li><?= Html::a('<i class="fa fa-pencil"></i>', ['polls/update', 'id' => $model->id], ['role'=>'modal-remote','style'=>'margin-top:-10px','title'=> 'Изменить', 'class'=>'panel-pencil'])?></li>
                        </ul>                                
                    </div>                            
                    </div> 
                <div class="panel-body panel-body-table" >                                
                    <table class="table table-bordered" style="width:100%" >
                        <thead>
                            <tr>
                                <th width="180px"><?=$model->getAttributeLabel('user_id')?></th>
                                <th width="300px"><?=$model->getAttributeLabel('category_id')?></th>
                                <th ><?=$model->getAttributeLabel('type')?></th>
                                <th ><?=$model->getAttributeLabel('publications')?></th>
                            </tr>

                            <tr>
                                <td><?=Html::encode($model->user->fio)?></td>
                                <td><?=PollCategory::findOne($model->category_id)->name?></td>
                                <td ><?= $model->getTypes($model->type)?></td>
                                <td><?= $model->publications?></td>
                            </tr>
                            <tr>
                                <th><?=$model->getAttributeLabel('hashtags')?></th>
                                <th><?=$model->getAttributeLabel('view_comment')?></th>
                                <th ><?=$model->getAttributeLabel('visibility')?></th>
                                <th><?=$model->getAttributeLabel('image')?></th>
                            </tr>
                            <tr>
                                <td><?= $model->hashtags?></td>
                                <td><?= $model->getViewComments($model->view_comment)?></td>
                                <td ><?= $model->getVisibilitys($model->visibility)?></td>
                                <td width="200px" rowspan="3"> 
                                    <?php if($model->image != null){?>
                                    <div id="links">
                                        <a class="gallery-item" href='/uploads/polls/<?= $model->image?>'>
                                            <?= ($model->image)?Html::img('/uploads/polls/'.$model->image,['style'=>'width:100px; height:70px;']):null;?>                                                                                                       
                                        </a>
                                    </div>
                                    <?php }?>
                                    <?php if($model->image == null){?>
                                        <img width="80px" height="80px" src="/img/no_image.jpg" >
                                    <?php }?>
                                </td>
                                
                            </tr>
                            <tr>
                                <th><?=$model->getAttributeLabel('date_cr')?></th>
                                <th><?=$model->getAttributeLabel('date_end')?></th>
                                <th width="180px"><?=$model->getAttributeLabel('status')?></th>
                                
                            </tr>
                            <tr>
                                <td><?= $model->date_cr != null ? Html::encode(\Yii::$app->formatter->asDate($model->date_cr, 'php:d.m.Y')) : '' ?></td>
                                <td><?= $model->date_end != null ? Html::encode(\Yii::$app->formatter->asDate($model->date_end, 'php:d.m.Y')) : '' ?></td>
                                <td ><?= $model->getStatuses($model->status)?></td>
                                
                            </tr>

                            <tr>
                                <th><?=$model->getAttributeLabel('term')?></th>
                                <th colspan="4"><?=$model->getAttributeLabel('question')?></th>
                                
                            </tr>
                   
                            <tr>
                                <td><?= $model->getTerms($model->term)?></td>
                                <td colspan="4"><?= $model->question?></td>
                                
                            </tr>
                        </tbody>
                    </table>                                
                </div>
            </div>
            </div>
            <div class="tab-pane" id="tab-second">
                <div class="faq-index">
                    <?php Pjax::begin(['enablePushState' => false, 'id' => 'crudsub-pjax']) ?>
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crudsub-datatable',
                            'dataProvider' => $subdataProvider,
                            // 'filterModel' => $subsearchModel,
                            'pjax'=>true,
                            'responsiveWrap' => false,
                            'columns' => require(__DIR__.'/_columns_subscribe_poll.php'),
                            'toolbar'=> '',          
                            'striped' => true,
                            'condensed' => true,
                            'responsive' => true,          
                            'panel' => [
                                'type' => 'warning', 
                                // 'heading' => '<i class="glyphicon glyphicon-list"></i> Подписаться на опрос',
                                'before'=>'',
                                'after'=>BulkButtonWidget::widget([
                                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>Удалить все',
                                                ['subscribe-to-poll/bulk-delete'] ,
                                                [
                                                    "class"=>"btn btn-danger btn-xs",
                                                    'role'=>'modal-remote-bulk',
                                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                                    'data-request-method'=>'post',
                                                    'data-confirm-title'=>'Подтвердите действие',
                                                    'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                                                ]),
                                        ]).                        
                                        '<div class="clearfix"></div>',
                            ]
                        ])?>
                    </div>
                    <?php Pjax::end() ?> 
                </div>               
            </div>
            <div class="tab-pane" id="tab-three">
                <div class="faq-index">
                    <?php Pjax::begin(['enablePushState' => false, 'id' => 'crudlike-pjax']) ?>
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crudlike-datatable',
                            'dataProvider' => $likedataProvider,
                            // 'filterModel' => $subsearchModel,
                            'pjax'=>true,
                            'responsiveWrap' => false,
                            'columns' => require(__DIR__.'/_columns_like.php'),
                            'toolbar'=> '',          
                            'striped' => true,
                            'condensed' => true, 
                            'responsive' => true,          
                            'panel' => [
                                'type' => 'warning', 
                                // 'heading' => '<i class="glyphicon glyphicon-list"></i> Подписаться на опрос',
                                'before'=>'',
                                'after'=>BulkButtonWidget::widget([
                                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>Удалить все',
                                                ['like/bulk-delete'] ,
                                                [
                                                    "class"=>"btn btn-danger btn-xs",
                                                    'role'=>'modal-remote-bulk',
                                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                                    'data-request-method'=>'post',
                                                    'data-confirm-title'=>'Подтвердите действие',
                                                    'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                                                ]),
                                        ]).                        
                                        '<div class="clearfix"></div>',
                            ]
                        ])?>
                    </div>
                    <?php Pjax::end() ?> 
                </div>               
            </div>                                              
        </div>
    </div>                                
</div>
<div class="panel panel-warning">
    <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title">Пункты опроса</h3>
        <div class="pull-right">
            <?= Html::a('Перейти к статистике&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-forward"></i>', ['polls/statistics'],['title'=> 'Перейти к статистике', 'class'=>'btn btn-warning'])?>                           
        </div>                                
    </div>

    <div class="panel-body panel-body-table">                                
        <table class="table table-bordered" style="width:100%">
            <thead> 
                <tr>
                    <th width="10px">№</th>
                    <?php if($type==2){ ?>
                    <th>Вариант ответа</th>
                    <?php }?>
                    <?php if($type==1){ ?>
                    <th>Вариант ответа</th>
                    <th>Картинка</th>
                    <?php }?>
                    <th width="40px">Процент</th>
                </tr>
                <?php $k=1; ?>
                <?php foreach ($pollitems as $model) { 
                    $answersall = Answers::find()->where(['poll_id'=>$id])->count();
                    $answers = Answers::find()->where(['poll_item_id'=>$model->id,'poll_id'=>$id])->count();
                    if($answers!=0){ 
                    $prosent=($answers/$answersall)*100;
                    $prosent_num = number_format($prosent, 1, '.', ' ');
                    }else{$prosent_num=0;}
                ?>
                <tr>
                    <td><?= $k ?></td>
                    <?php if($type==2){ ?>
                    <td><?= $model->option?></td>
                    <?php }?>
                    <?php if($type==1){ ?>
                    <td><?= $model->option?></td>
                    <td> 
                        <?php if($model->image!=null){?>
                        <div id="links1">
                            <a class="gallery-item" href='/uploads/pollitem/<?= $model->image?>'>
                                <?= ($model->image)?Html::img('/uploads/pollitem/'.$model->image,['style'=>'width:100px; height:70px;']):null;?>                                                                                                       
                            </a>
                        </div>
                        <?php }?>
                        <?php if($model->image==null){?>
                            <img width="80px" height="80px" src="/img/no_image.jpg" >
                        <?php }?>
                    </td>  
                    <?php }?>
                    <td><?= $prosent_num?> %</td>   
                </tr>
                <?php $k++;}?>
            </tbody>
        </table>                                
    </div>
</div>
<div class="panel panel-warning" >
    <div class="panel-heading ui-draggable-handle">
        <h3 class="panel-title">Комментарий</h3>                             
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
                        <?php if($model->from!=""){?>
                            <div class="item"> 
                                <div class="image">
                                    <?php if ($model->userFrom->foto == '') {?>
                                        <img src="/extra/images/users/no-image.jpg" >
                                    <?php } else {?>
                                        <?= ($model->userFrom->foto)?Html::img('/uploads/user/foto/'.$model->userFrom->foto,['style'=>'min-width: 40px;min-height: 40px']):null;?>
                                    <?php }?>
                                </div>                                
                                <div class="text">
                                    <div class="heading">
                                        <a href="#"><?=$model->userFrom->fio?></a>
                                        
                                        <span class="date" style="margin-right:60px"><?= date( 'H:i d.m.y', strtotime($model->date_cr) ) ?></span>
                                        <?php Pjax::begin(['enablePushState' => false, 'id' => 'chat-pjax']) ?>
                                        <span class="date" style="margin-top:-20px">
                                            <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['chat/update', 'id' => $model->id], ['role'=>'modal-remote','title'=> 'Изменить', 'style' => 'color:red', 'class'=>' btn-xs'])?>
                                            &nbsp;&nbsp;&nbsp;<?= 
                                                 Html::a('<span class="glyphicon glyphicon-trash"></span>', ['chat/close', 'id' => $model->id], [
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
                                        <?= ($model->userTo->foto)?Html::img('/uploads/user/foto/'.$model->userTo->foto,['style'=>'min-width: 40px;min-height: 40px']):null;?>
                                    <?php }?>
                                </div>                                 
                                <div class="text">
                                    <div class="heading">
                                        <a href="#"><?=$model->userTo->fio?></a>
                                        <span class="date" style="margin-right:60px"><?= date( 'H:i d.m.y', strtotime($model->date_cr) ) ?></span>
                                        <?php Pjax::begin(['enablePushState' => false, 'id' => 'chat-pjax']) ?>
                                        <span class="date" style="margin-top:-20px">
                                            <?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['chat/update', 'id' => $model->id], ['role'=>'modal-remote','title'=> 'Изменить', 'style' => 'color:red', 'class'=>' btn-xs'])?>
                                            &nbsp;&nbsp;&nbsp;<?= 
                                                 Html::a('<span class="glyphicon glyphicon-trash"></span>', ['chat/close', 'id' => $model->id], [
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
                        
                    <?php } ?>
                   
                </div> 
                <div class="panel-footer">
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
                                <a>Нет комментариев на этой странице.</a>
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
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div> 
 <script>            
    document.getElementById('links').onclick = function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement;
        var link = target.src ? target.parentNode : target;
        var options = {index: link, event: event,onclosed: function(){
                setTimeout(function(){
                    $("body").css("overflow","");
                },200);                        
            }};
        var links = this.getElementsByTagName('a');
        blueimp.Gallery(links, options);
    };
</script>     
 <script>            
    document.getElementById('links1').onclick = function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement;
        var link = target.src ? target.parentNode : target;
        var options = {index: link, event: event,onclosed: function(){
                setTimeout(function(){
                    $("body").css("overflow","");
                },200);                        
            }};
        var links1 = this.getElementsByTagName('a');
        blueimp.Gallery(links1, options);
    };
</script>   