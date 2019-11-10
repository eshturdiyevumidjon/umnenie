<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Like */
?>
<div class="like-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'poll_id',
            'user_id',
            'cr_date',
        ],
    ]) ?>

</div>
