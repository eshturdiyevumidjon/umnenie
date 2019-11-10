<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\PollItems */
?>
<div class="poll-items-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'poll_id',
            'option',
            'image',
            [
                'attribute'=>'image',
                'format'=>'html',  
                'value' => function ($data) {
                    if($data->image != null) return '<a>'.($data->image)?Html::img('/uploads/pollitem/'.$data->image,['style'=>'width:100px; height:70px;text-align:center']):null.'</a>';
                    if($data->image == null) return '<a>'.($data->image)?Html::img('/img/'.'no_image.jpg',['style'=>'width:70px; height:70px;text-align:center']):null.'</a>';
                },
            ],
        ],
    ]) ?>

</div>
