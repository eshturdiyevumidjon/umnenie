<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Elected */
?>
<div class="elected-view">
 
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
