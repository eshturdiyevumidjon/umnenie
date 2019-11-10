<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubscribeToUser */
?>
<div class="subscribe-to-user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'user_to',
            'date_cr',
        ],
    ]) ?>

</div>
