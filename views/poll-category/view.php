<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PollCategory */
?>
<div class="poll-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
