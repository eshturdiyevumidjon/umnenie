<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Чат';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?> 
<div class="tab-pane active" id="tab-first">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud1-datatable',
            'dataProvider' => $dataProvider1,
            'filterModel' => $searchModel1,
            'pjax'=>true,
            'responsiveWrap' => false,
            'columns' => require(__DIR__.'/_columns_chat.php'),
            'toolbar'=>'',     
            'striped' => true,
            'condensed' => true,
            'responsive' => true,           
            'panel' => [
                'type' => 'warning', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Чат',
                'before'=>'',
                // 'after'=>BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>Удалить все',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'Подтвердите действие',
                //                     'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                //                 ]),
                //         ]).                        
                //         '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>