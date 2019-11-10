<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use app\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */
	$session = Yii::$app->session;
    if( isset($session['theme']) ) $theme = $session['theme'];
    else $theme = '/css/theme-default.css';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="body-full-height" >
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" type="text/css" id="theme" href="<?=$theme?>"/>
</head>
<body>

<?php $this->beginBody() ?>

	<?= Alert::widget() ?>
    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
