<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\Users;
use unclead\multipleinput\MultipleInput;
use kartik\tabs\TabsX;
/*echo "f=".$model->scenario;
echo "<br> model_step = ". $model->step;*/

$items = [
    [
        'label'=>'Физическое лицо',
        'headerOptions' => ['class' => 'disabled']
    ],
    [
        'label'=>'Юридическое лицо',
        'content'=> $this->render('entity_from', ['model' => $model]),
        'active'=> true,
    ],
    [
        'label'=>'Администратор проекта',
        'headerOptions' => ['class' => 'disabled']
    ],    
];


?>

<div class="client-form">
    <div class="box box-default">
        <div class="box-body">


    <?php // Above
        echo TabsX::widget([
            'items'=>$items,
            'position'=>TabsX::POS_ABOVE,
            'encodeLabels'=>false,
            'bordered'=>true,
        ]);
        ?>
    

</div>
</div>