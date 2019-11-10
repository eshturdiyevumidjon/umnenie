<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Users;
use yii\helpers\Html;
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
            'model' => $blocksearchModel,
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
        'template' => '{leadDelete}',
        'dropdown' => false,
        'vAlign'=>'middle',
        'buttons'  => [
            'leadUpdate' => function ($url, $model) {
                    $url = Url::to(['/block-user/updates', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip']);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/block-user/delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить', 
                              'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                              'data-request-method'=>'post',
                              'data-toggle'=>'tooltip',
                              'data-confirm-title'=>'Подтвердите действие',
                              'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                    ]);
            },
        ],
    ],

];   