<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
/*use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;*/
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\JolliAsset;

if (class_exists('AppAsset')) {
        AppAsset::register($this);
    } else {
        JolliAsset::register($this);
    }

if (Yii::$app->controller->action->id === 'login' || Yii::$app->controller->action->id === 'register' /*|| Yii::$app->controller->id === 'default'*/ || Yii::$app->controller->id === 'setting') { 
    echo $this->render( 'main-login', ['content' => $content] );
} else{
        $session = Yii::$app->session;
        if( isset($session['theme']) ) $theme = $session['theme'];
        else $theme = '/css/theme-default.css';

        if($session['st_sb_toggled'] != null) $st_sb_toggled = $session['st_sb_toggled'];
        else $st_sb_toggled = 0;

        if($session['st_head_fixed'] != null) $st_head_fixed = $session['st_head_fixed'];
        else $st_head_fixed = 0;

        if($session['st_sb_right'] != null) $st_sb_right = $session['st_sb_right'];
        else $st_sb_right = 0;

        if($session['st_sb_custom'] != null) $st_sb_custom = $session['st_sb_custom'];
        else $st_sb_custom = 0;

        if($session['st_sb_fixed'] != null) $st_sb_fixed = $session['st_sb_fixed'];
        else $st_sb_fixed = 1;

        if($session['st_sb_scroll'] != null) $st_sb_scroll = $session['st_sb_scroll'];
        else $st_sb_scroll = 1;

        if($session['st_layout_boxed'] != null) $st_layout_boxed = $session['st_layout_boxed'];
        else $st_layout_boxed = 0;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>        
        <!-- META SECTION -->
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>            
        <?php $this->head() ?>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?=$theme?>"/>
    </head>

     <body>
        <?php $this->beginBody() ?>

        <div class="page-container">

            <!-- menu nastroykasining boshlanishi -->
            <input type="hidden" name="st_head_fixed" id="st_head_fixed" value="<?=$st_head_fixed?>" >
            <input type="hidden" name="st_sb_toggled" id="st_sb_toggled" value="<?=$st_sb_toggled?>" >
            <input type="hidden" name="st_sb_right" id="st_sb_right" value="<?=$st_sb_right?>" >
            <input type="hidden" name="st_sb_custom" id="st_sb_custom" value="<?=$st_sb_custom?>" >
            <input type="hidden" name="st_sb_fixed" id="st_sb_fixed" value="<?=$st_sb_fixed?>" >
            <input type="hidden" name="st_sb_scroll" id="st_sb_scroll" value="<?=$st_sb_scroll?>" >
            <input type="hidden" name="st_layout_boxed" id="st_layout_boxed" value="<?=$st_layout_boxed?>" >
            <!-- menu nastroykaning tugashi -->

            <div class="page-sidebar">
                <?= $this->render(
                'left.php'
                ) ?>  
            </div>
            
            <div class="page-content">
                <?= $this->render(
                'header.php'
                ) ?>

                <?= $this->render(
                    'content.php',
                    ['content' => $content]
                ) ?>                                
                    
                <!-- START DASHBOARD CHART -->
                <!-- <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
                <div class="block-full-width">                                                                       
                </div>     -->                
                <!-- END DASHBOARD CHART -->
                    
            </div>                   
        </div>            
    <!-- </div> -->

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
    <?php }
?>