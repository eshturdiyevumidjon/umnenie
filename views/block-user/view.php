<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BlockUser */
?>
<div class="block-user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_from',
            'user_to',
            'date_cr',
        ],
    ]) ?>

</div>
