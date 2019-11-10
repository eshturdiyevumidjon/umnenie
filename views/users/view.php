<?php

use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset; 
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
$this->title = 'Информация';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this); 
?>
<br> 
<div class="faq-index" style="overflow-x:auto;">
    <div class="panel panel-default tabs" style="min-width:490px">                          
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab-first" role="tab" data-toggle="tab">Информация</a></li>
            <li><a href="#tab-second" role="tab" data-toggle="tab">Подписчики</a></li>
            <li><a href="#tab-thrie" role="tab" data-toggle="tab">Подписки</a></li>
            <li><a href="#tab-four" role="tab" data-toggle="tab">Блокированные пользователи</a></li>
            <li><a href="#tab-five" role="tab" data-toggle="tab">Избранные</a></li>
        </ul>
        <div class="panel-body tab-content">
            <div class="tab-pane active" id="tab-first">
                <?php Pjax::begin(['enablePushState' => false, 'id' => 'about-pjax']) ?>
                
                 <div class="panel panel-warning" style="min-width:470px">
                    <div class="panel-heading ui-draggable-handle">
                        <div style="margin-top: 5px;margin-right:5px">
                        <ul class="panel-controls">
                            <li><?= Html::a('<i class="fa fa-pencil"></i>', ['users/update', 'id' => $model->id], ['role'=>'modal-remote','style'=>'margin-top:-10px','title'=> 'Изменить', 'class'=>'panel-pencil'])?></li>
                        </ul>                                
                    </div>                            
                    </div>   
                    <div class="panel-body panel-body-table">                                
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="300px" colspan="2"><?=$model->getAttributeLabel('fio')?></th>
                                <th ><?=$model->getAttributeLabel('type')?></th>
                                <th ><?=$model->getAttributeLabel('username')?></th>
                            </tr>

                            <tr>
                                <td colspan="2"><?=Html::encode($model->fio)?></td>
                                <td ><?= $model->getTypes($model->type)?></td>
                                <td><?= $model->username?></td>
                            </tr>
                            <tr>
                                <th><?=$model->getAttributeLabel('category_id')?></th>
                                <th ><?=$model->getAttributeLabel('specialization_id')?></th>
                                <th colspan="2"><?=$model->getAttributeLabel('site')?></th>
                                
                            </tr>
                            <tr>
                                <td><?=Html::decode($model->getCategoryName())?></td>
                                <td ><?=Html::decode($model->getSpecialisationName())?></td>
                                <td ><?= $model->site?></td>
                                
                            </tr>
                            <tr>
                                <th><?=$model->getAttributeLabel('phone')?></th>
                                <th><?=$model->getAttributeLabel('facebook')?></th>
                                <th><?=$model->getAttributeLabel('telegram')?></th>
                                <th><?=$model->getAttributeLabel('twitter')?></th>
                            </tr>
                            <tr>
                                <td><?= $model->phone ?></td>
                                <td><?= $model->facebook?></td>
                                <td ><?= $model->telegram?></td>
                                <td><?= $model->twitter?></td>
                            </tr>
                            <tr>
                                <th width="300px"><?=$model->getAttributeLabel('email')?></th>
                                <th><?=$model->getAttributeLabel('gender')?></th>
                                <th><?=$model->getAttributeLabel('verified')?></th>
                                <th><?=$model->getAttributeLabel('profi_status')?></th>
                            </tr>
                            <tr>
                                <td><?=Html::encode($model->email)?></td>
                                <td ><?= $model->getGenders($model->gender)?></td>
                                <td >
                                    <label class="checkbox pull-right">
                                        <input style="margin-top: -7px;" <?= $model->verified == 1 ? 'checked' : '' ?> type="checkbox" disabled="disabled">
                                    </label>
                                </td>
                                <td >
                                    <label class="checkbox pull-right">
                                        <input style="margin-top: -7px;" <?= $model->profi_status == 1 ? 'checked' : '' ?> type="checkbox" disabled="disabled">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2"><?=$model->getAttributeLabel('address')?></th>
                                <th><?=$model->getAttributeLabel('foto')?></th>
                                <th><?=$model->getAttributeLabel('logo')?></th>
                            </tr>
                            <tr>
                                <td colspan="2"><?= $model->address ?></td>
                                <td rowspan="5">
                                    <?php if($model->foto != null){?>
                                    <div id="links">
                                        <a class="gallery-item" href='/uploads/user/foto/<?= $model->foto?>'>
                                            <?= ($model->foto)?Html::img('/uploads/user/foto/'.$model->foto,['style'=>'width:100px; height:70px;']):null;?>                                                                                                       
                                        </a>
                                    </div>
                                    <?php }?>
                                    <?php if($model->foto == null){?>
                                        <img width="80px" height="80px" src="/img/no_image.jpg" >
                                    <?php }?>
                                </td>
                                <td rowspan="5">
                                    <?php if($model->logo != null){?>
                                    <div id="links1">
                                        <a class="gallery-item" href='/uploads/user/logo/<?= $model->logo?>'>
                                            <?= ($model->logo)?Html::img('/uploads/user/logo/'.$model->logo,['style'=>'width:100px; height:70px;']):null;?>                                                                                                       
                                        </a>
                                    </div>
                                    <?php }?>
                                    <?php if($model->logo == null){?>
                                        <img width="80px" height="80px" src="/img/no_image.jpg" >
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2"><?=$model->getAttributeLabel('comments')?></th>

                            </tr>
                            <tr>
                                <td colspan="2"><?= $model->comments ?></td>
                            </tr>
                            <?php if($model->type==2){?>
                            <tr>
                                <th><?=$model->getAttributeLabel('org_name')?></th>
                                <th><?=$model->getAttributeLabel('mobile_phone')?></th>
                            </tr>
                            <tr>
                                <td><?= $model->org_name ?></td>
                                <td><?= $model->mobile_phone?></td>
                            </tr>
                            <tr>
                                <th colspan="4"><?=$model->getAttributeLabel('factual_address')?></th>
                            </tr>
                            <tr>
                                <td colspan="4"><?= $model->factual_address ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>                                
                </div>
                </div>
                <?php Pjax::end() ?> 
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
                            'columns' => require(__DIR__.'/columns/_columns_subscribe_user.php'),
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
                                                ['subscribe-to-user/bulk-delete'] ,
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
            <div class="tab-pane" id="tab-thrie">
                <div class="faq-index">
                    <?php Pjax::begin(['enablePushState' => false, 'id' => 'crudsubto-pjax']) ?>
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crudsubto-datatable',
                            'dataProvider' => $subdataProvider2,
                            // 'filterModel' => $subsearchModel,
                            'pjax'=>true,
                            'responsiveWrap' => false,
                            'columns' => require(__DIR__.'/columns/_columns_subscribe_user_to.php'),
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
                                                ['subscribe-to-user/bulk-delete-to'] ,
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
            <div class="tab-pane" id="tab-four">
                <div class="faq-index">
                    <?php Pjax::begin(['enablePushState' => false, 'id' => 'crudblock-pjax']) ?>
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crudblock-datatable',
                            'dataProvider' => $blockdataProvider,
                            // 'filterModel' => $subsearchModel,
                            'pjax'=>true,
                            'responsiveWrap' => false,
                            'columns' => require(__DIR__.'/columns/_columns_block_user.php'),
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
                                                ['subscribe-to-user/bulk-delete'] ,
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
            <div class="tab-pane" id="tab-five">
                <div class="faq-index">
                    <?php Pjax::begin(['enablePushState' => false, 'id' => 'crudselected-pjax']) ?>
                    <div id="ajaxCrudDatatable">
                        <?=GridView::widget([
                            'id'=>'crudselected-datatable',
                            'dataProvider' => $selecteddataProvider,
                            // 'filterModel' => $subsearchModel,
                            'pjax'=>true,
                            'responsiveWrap' => false,
                            'columns' => require(__DIR__.'/columns/_columns_selected.php'),
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
                                                ['elected/bulk-delete'] ,
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