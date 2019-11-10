<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

?>
<div class="users-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div> 
    
    <?php/* if($model->scenario == Client::SCENARIO_INDIVIDUAL): ?>
        <?= $this->render('individual', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>
 

    <?php if($model->scenario == Client::SCENARIO_ENTITY): ?>
        <?= $this->render('entity', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>


    <?php if($model->scenario == Client::SCENARIO_ADMINISTRATOR): ?>
        <?= $this->render('administrator', [
            'model' => $model,
        ]) ?>
    <?php endif; */?>
	
