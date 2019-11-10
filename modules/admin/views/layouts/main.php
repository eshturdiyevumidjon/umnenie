<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html; 
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\bootstrap\Modal;
use app\assets\FrontendAsset;
use yii\widgets\Pjax;
use app\models\Users; 
use app\models\Category;
use app\models\Restoran;
use app\models\CategoryMeal; 
use app\models\Orders; 
use app\models\subscription;
FrontendAsset::register($this);

$subscription=new Subscription();
if (isset($_GET['email'])) {
    $subscription->email=$_GET['email'];
    $subscription->save();
}

?>
<?php $this->beginPage() ?> 
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- <div class="wrap umskot"> -->
    <!-- <div class="container"> -->
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    <!-- </div> -->
<!-- </div>
 -->
        
    <div class="container-form">
        <div class="container-form-left">
            <h4 class="container-form-left-title">Подпишись на рассылку</h4>
            <p class="container-form-left-text">Получите доступ к специальным предложениям раньше других</p>
        </div>
        <div class="container-form-right"> 
            <form class="container-form-right-form" method="get">
                <fieldset class="container-form-right-form-field">
                    <label class="container-form-right-form-label" for=""></label>
                    <input class="container-form-right-form-input" id="email" required="" name="email" type="email" placeholder="Email"/>
                </fieldset>
                <fieldset class="container-form-right-form-field">
                    <button type="submit" class="container-form-right-form-button">Подписаться</button>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="footer">
        <div class="footer-logo">
            <i class="footer-logo-img"></i>
        </div>
        <div class="footer-content">
            <div class="footer-content-menu">
                <ul class="footer-menu-ul">
                    <div class="footer-menu-ul-block-1">
                        <li class="footer-menu-li"><a href="<?=Url::toRoute(['default/index'])?>">Главная</a></li>
                        <li class="footer-menu-li"><a href="<?=Url::toRoute(['default/about'])?>">О компании</a></li>
                    </div>
                    <div class="footer-menu-ul-block-2">
                        <li class="footer-menu-li"><a href="<?=Url::toRoute(['default/objects'])?>">Объекты</a></li>
                        <li class="footer-menu-li"><a href="<?=Url::toRoute(['default/contacts'])?>">Контакты</a></li>
                    </div>
                </ul>
            </div>
            <div class="footer-content-adress">
                <i class="footer-content-adress-icon-location"></i>
                <p class="footer-content-adress-text">Шайхонтохурский район, массив Джар арык, дом 7, кв 29</p>
                <i class="footer-content-adress-icon-email"></i>
                <p class="footer-content-adress-email">email info@nesatex.it</p>
                <p class="footer-content-adress-num">+998 94 355 55 55</p>
                <button class="footer-content-adress-button">Обратная связь</button>
            </div>
            <div class="footer-content-info">
                <div class="footer-bottom-icons">
                    <i class="footer-bottom-icons-google"></i>
                    <i class="footer-bottom-icons-instagram"></i>
                    <i class="footer-bottom-icons-facebook"></i>
                    <i class="footer-bottom-icons-twitter"></i>
                </div>
                <p class="footer-content-info-text-1">Все права на публикуемые на сайте материалы принадлежат ПАО «Группа Компаний ПИК» © 2000 — 2019. Любая информация, представленная на данном сайте, носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями статьи 437 ГК РФ. <br> Раскрытие информации ПАО «Группа Компаний ПИК» также доступно в сети Интернет на странице информационного агентства, аккредитованного ЦБ РФ на раскрытие информации – ООО«Интерфакс-ЦРКИ»Раскрытие информации ООО «ПИК-Корпорация» (подконтрольная организация ПАО «Группа Компаний ПИК») доступно в сети Интернет на странице информационного агентства, аккредитованного ЦБ РФ на раскрытие информации –ООО«Интерфакс-ЦРКИ»</p>
                <p class="footer-content-info-text-2">Сайт разработан: DeepX</p>
            </div>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "size" => "large",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>