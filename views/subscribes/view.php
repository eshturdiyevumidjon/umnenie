<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */
?>
<div class="subscribes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'user_from',
            'date_cr',
        ],
    ]) ?>

</div>
