<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Specialization */
?>
<div class="specialization-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
