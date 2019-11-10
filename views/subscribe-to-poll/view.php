<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubscribeToPoll */
?>
<div class="subscribe-to-poll-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'poll_id',
            'date_cr',
        ],
    ]) ?>

</div>
