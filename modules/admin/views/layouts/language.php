<?php

use yii\bootstrap\Html;
use Yii;

if(Yii::$app->language =='ru')
{
	echo Html::a('English',array_merge(Yii::$app->request->get(),
	[Yii::$app->controller->route,'language'=>'en'] ));
}    
else{
	echo Html::a('Rus tili',array_merge(Yii::$app->request->get(),
	[Yii::$app->controller->route,'language'=>'ru'] ));
}