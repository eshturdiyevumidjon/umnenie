<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Users;
use kartik\date\DatePicker;
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
        'attribute'=>'user_from',
        'filter' => ArrayHelper::map(Users::find()->all(),'id','fio'),
        'content'=> function($data){
            return $data->userFrom->fio; 
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_to',
        'filter' => ArrayHelper::map(Users::find()->all(),'id','fio'),
        'content'=> function($data){
            return $data->userTo->fio; 
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content' => function ($data) {
            return \Yii::$app->formatter->asDate($data->date_cr, 'php:H:i:s d.m.Y');
        },
        'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'date_cr',
            'language' =>'ru-Ru',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true, 
                'format' => 'yyyy-mm-dd',
            ]
        ]),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{delete}',
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