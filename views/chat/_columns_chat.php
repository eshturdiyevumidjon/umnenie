<?php
use yii\helpers\Url;
use app\models\Users;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\date\DatePicker; 
return [
 
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'chat_id',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{leadView}',
        'dropdown' => false, 
        'vAlign'=>'middle',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                    $url = Url::to(['/chat/sends', 'chat_id' => $model->chat_id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title'=>'Посмотреть', 'data-toggle'=>'tooltip']);
            },
        ],
    ],

];   