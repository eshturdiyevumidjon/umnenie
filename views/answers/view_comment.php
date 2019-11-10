<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Answers */
?>
<div class="answers-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        [
            'attribute'=>'user_id',
            'value'=> function($data){
                return $data->user->fio;
            }
        ],
        
            // 'poll_id',
            // 'poll_item_id',
            // 'user_id',
            [
                'attribute'=>'comment',
                'format'=>'html',   
                'contentOptions' => [
                    'style'=>'max-width:150px; min-height:100px; overflow: auto; word-wrap: break-word;'
                ],
            ],
        ],
    ]) ?>

</div>
