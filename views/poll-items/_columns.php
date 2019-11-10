<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Polls;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'poll_id',
        'filter' => ArrayHelper::map(Polls::find()->all(),'id','id'),
        'content'=> function($data){
            return $data->polls->id;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'option',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'image',
        'width' =>'70px',
        'format'=>'html',  
        'content' => function ($data) {
            if($data->image != null) return '<a>'.($data->image)?Html::img('/uploads/pollitem/'.$data->image,['style'=>'width:70px; height:70px;text-align:center']):null.'</a>';
            if($data->image == null) return '<a>'.($data->image)?Html::img('/img/'.'no_image.jpg',['style'=>'width:70px; height:70px;text-align:center']):null.'</a>';
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update} {delete}',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Посмотреть','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'], 
    ],

];   