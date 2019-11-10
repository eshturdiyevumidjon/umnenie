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
        'attribute'=>'poll_id',
        'content'=> function($data){
            return $data->poll->id; 
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cr_date',
        'content' => function ($data) {
            return \Yii::$app->formatter->asDate($data->cr_date, 'php:H:i:s d.m.Y');
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{leadDelete}',
        'dropdown' => false,
        'vAlign'=>'middle',
        'buttons'  => [
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/elected/delete', 'id' => $model->id]);
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