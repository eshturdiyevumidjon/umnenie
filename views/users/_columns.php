<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\PollCategory;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'checkboxOptions' => function($model) {
            if($model->id == 1)return ['disabled' => true];
            if($model->id != 1)return ['disabled' => false];
         },
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'foto',
        'width' =>'70px',
        'format'=>'html',  
        'content' => function ($data) {
            /*if($data->type == 2) return Html::img('/uploads/user/logo/'.$data->logo,['style'=>'width:70px; height:70px;text-align:center']);
            else*/ return Html::img('/uploads/user/foto/'.$data->foto,['style'=>'width:70px; height:70px;text-align:center']);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'filter' => ArrayHelper::map(PollCategory::find()->all(),'id','name'),
        'content'=> function($data){
            $array = explode(',', $data->category_id);
            $result = "";
            foreach ($array as $value) {
                $cat = PollCategory::findOne($value);
                if($cat != null) $result .= $cat->name.';<br>';
            }
            return $result;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'filter' => array('1' => 'Физическое лицо' , '2' => 'Юридическое лицо', '3' => 'Администратор проекта'),
        'content' => function ($data) {
           if($data->type == 1) return 'Физическое лицо';
           if($data->type == 2) return 'Юридическое лицо';
           if($data->type == 3) return 'Администратор проекта';
       },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view} {leadDelete}',
        'buttons'  => [
            'leadDelete' => function ($url, $model) {
                if($model->id != 1){
                    $url = Url::to(['/users/delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить', 
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                    ]);
                }
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['title'=>'Посмотреть','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'], 
    ],

];   