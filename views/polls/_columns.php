<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Users;
use app\models\PollCategory;
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
        'attribute'=>'user_id',
        'filter' => ArrayHelper::map(Users::find()->all(),'id','fio'),
        'content'=> function($data){
            return $data->user->fio;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content' => function ($data) {
            return \Yii::$app->formatter->asDate($data->date_cr, 'php:d.m.Y');
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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_end',
        'content' => function ($data) {
            return \Yii::$app->formatter->asDate($data->date_end, 'php:d.m.Y');
        },
        'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'date_end',
            'language' =>'ru-Ru',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true, 
                'format' => 'yyyy-mm-dd',
            ]
        ]),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'filter' => ArrayHelper::map(PollCategory::find()->all(),'id','name'),
        'content'=> function($data){
            if($data->category_id != null){
                $cat = PollCategory::findOne($data->category_id);
                return $cat->name;
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'filter' => array('1' => 'Вид с выбором фоновой картинки' , '2' => 'Вид с текстовым описанием'),
        'content' => function ($data) {
           if($data->type == 1) return 'Вид с выбором фоновой картинки';
           if($data->type == 2) return 'Вид с текстовым описанием';
       },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'filter' => array('1' => 'Опубликован' , '2' => 'Черновик', '3' => 'Заблокирован',),
        'content' => function ($data) {
           if($data->status == 1) return 'Опубликован';
           if($data->status == 2) return 'Черновик';
           if($data->status == 3) return 'Заблокирован';
       },
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'visibility',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'term',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'view_comment',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'hashtags',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'publications',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {delete}',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>[/*'role'=>'modal-remote',*/'title'=>'Посмотреть','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'], 
    ],

];   